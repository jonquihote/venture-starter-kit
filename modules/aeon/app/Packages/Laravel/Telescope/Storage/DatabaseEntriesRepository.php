<?php

namespace Venture\Aeon\Packages\Laravel\Telescope\Storage;

use DateTimeInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Telescope\Contracts\ClearableRepository;
use Laravel\Telescope\Contracts\EntriesRepository as Contract;
use Laravel\Telescope\Contracts\PrunableRepository;
use Laravel\Telescope\Contracts\TerminableRepository;
use Laravel\Telescope\EntryResult;
use Laravel\Telescope\EntryType;
use Laravel\Telescope\EntryUpdate;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Storage\EntryQueryOptions;
use Throwable;

class DatabaseEntriesRepository implements ClearableRepository, Contract, PrunableRepository, TerminableRepository
{
    /**
     * The database connection name that should be used.
     *
     * @var string
     */
    protected $connection;

    /**
     * The number of entries that will be inserted at once into the database.
     *
     * @var int
     */
    protected $chunkSize = 1000;

    /**
     * The tags currently being monitored.
     *
     * @var array|null
     */
    protected $monitoredTags;

    /**
     * Create a new database repository.
     *
     * @return void
     */
    public function __construct(string $connection, ?int $chunkSize = null)
    {
        $this->connection = $connection;

        if ($chunkSize) {
            $this->chunkSize = $chunkSize;
        }
    }

    /**
     * Find the entry with the given ID.
     *
     * @param  mixed  $id
     */
    public function find($id): EntryResult
    {
        $entry = EntryModel::on($this->connection)->whereUuid($id)->firstOrFail();

        $tags = $this->table('laravel_telescope_entries_tags')
            ->where('entry_uuid', $id)
            ->pluck('tag')
            ->all();

        return new EntryResult(
            $entry->uuid,
            null,
            $entry->batch_id,
            $entry->type,
            $entry->family_hash,
            $entry->content,
            $entry->created_at,
            $tags
        );
    }

    /**
     * Return all the entries of a given type.
     *
     * @param  string|null  $type
     * @return Collection|EntryResult[]
     */
    public function get($type, EntryQueryOptions $options)
    {
        return EntryModel::on($this->connection)
            ->withTelescopeOptions($type, $options)
            ->take($options->limit)
            ->orderByDesc('sequence')
            ->get()->reject(function ($entry) {
                return ! is_array($entry->content);
            })->map(function ($entry) {
                return new EntryResult(
                    $entry->uuid,
                    $entry->sequence,
                    $entry->batch_id,
                    $entry->type,
                    $entry->family_hash,
                    $entry->content,
                    $entry->created_at,
                    []
                );
            })->values();
    }

    /**
     * Counts the occurences of an exception.
     *
     * @return int
     */
    protected function countExceptionOccurences(IncomingEntry $exception)
    {
        return $this->table('laravel_telescope_entries')
            ->where('type', EntryType::EXCEPTION)
            ->where('family_hash', $exception->familyHash())
            ->count();
    }

    /**
     * Store the given array of entries.
     *
     * @param  Collection|IncomingEntry[]  $entries
     * @return void
     */
    public function store(Collection $entries)
    {
        if ($entries->isEmpty()) {
            return;
        }

        [$exceptions, $entries] = $entries->partition->isException();

        $this->storeExceptions($exceptions);

        $table = $this->table('laravel_telescope_entries');

        $entries->chunk($this->chunkSize)->each(function ($chunked) use ($table): void {
            $table->insert($chunked->map(function ($entry) {
                $entry->content = json_encode($entry->content, JSON_INVALID_UTF8_SUBSTITUTE);

                return $entry->toArray();
            })->toArray());
        });

        $this->storeTags($entries->pluck('tags', 'uuid'));
    }

    /**
     * Store the given array of exception entries.
     *
     * @param  Collection|IncomingEntry[]  $exceptions
     * @return void
     */
    protected function storeExceptions(Collection $exceptions)
    {
        $exceptions->chunk($this->chunkSize)->each(function ($chunked): void {
            $this->table('laravel_telescope_entries')->insert($chunked->map(function ($exception) {
                $occurrences = $this->countExceptionOccurences($exception);

                $this->table('laravel_telescope_entries')
                    ->where('type', EntryType::EXCEPTION)
                    ->where('family_hash', $exception->familyHash())
                    ->where('should_display_on_index', true)
                    ->update(['should_display_on_index' => false]);

                return array_merge($exception->toArray(), [
                    'family_hash' => $exception->familyHash(),
                    'content' => json_encode(array_merge(
                        $exception->content, ['occurrences' => $occurrences + 1]
                    )),
                ]);
            })->toArray());
        });

        $this->storeTags($exceptions->pluck('tags', 'uuid'));
    }

    /**
     * Store the tags for the given entries.
     *
     * @return void
     */
    protected function storeTags(Collection $results)
    {
        $results->chunk($this->chunkSize)->each(function ($chunked): void {
            try {
                $this->table('laravel_telescope_entries_tags')->insert($chunked->flatMap(function ($tags, $uuid) {
                    return collect($tags)->map(function ($tag) use ($uuid) {
                        return [
                            'entry_uuid' => $uuid,
                            'tag' => $tag,
                        ];
                    });
                })->all());
            } catch (UniqueConstraintViolationException $e) {
                // Ignore tags that already exist...
            }
        });
    }

    /**
     * Store the given entry updates and return the failed updates.
     *
     * @param  Collection|EntryUpdate[]  $updates
     * @return Collection|null
     */
    public function update(Collection $updates)
    {
        $failedUpdates = [];

        foreach ($updates as $update) {
            $entry = $this->table('laravel_telescope_entries')
                ->where('uuid', $update->uuid)
                ->where('type', $update->type)
                ->first();

            if (! $entry) {
                $failedUpdates[] = $update;

                continue;
            }

            $content = json_encode(array_merge(
                json_decode($entry->content ?? $entry['content'] ?? [], true) ?: [], $update->changes
            ));

            $this->table('laravel_telescope_entries')
                ->where('uuid', $update->uuid)
                ->where('type', $update->type)
                ->update(['content' => $content]);

            $this->updateTags($update);
        }

        return collect($failedUpdates);
    }

    /**
     * Update tags of the given entry.
     *
     * @param  EntryUpdate  $entry
     * @return void
     */
    protected function updateTags($entry)
    {
        if (! empty($entry->tagsChanges['added'])) {
            try {
                $this->table('laravel_telescope_entries_tags')->insert(
                    collect($entry->tagsChanges['added'])->map(function ($tag) use ($entry) {
                        return [
                            'entry_uuid' => $entry->uuid,
                            'tag' => $tag,
                        ];
                    })->toArray()
                );
            } catch (UniqueConstraintViolationException $e) {
                // Ignore tags that already exist...
            }
        }

        collect($entry->tagsChanges['removed'])->each(function ($tag) use ($entry): void {
            $this->table('laravel_telescope_entries_tags')->where([
                'entry_uuid' => $entry->uuid,
                'tag' => $tag,
            ])->delete();
        });
    }

    /**
     * Load the monitored tags from storage.
     *
     * @return void
     */
    public function loadMonitoredTags()
    {
        try {
            $this->monitoredTags = $this->monitoring();
        } catch (Throwable $e) {
            $this->monitoredTags = [];
        }
    }

    /**
     * Determine if any of the given tags are currently being monitored.
     *
     * @return bool
     */
    public function isMonitoring(array $tags)
    {
        if (is_null($this->monitoredTags)) {
            $this->loadMonitoredTags();
        }

        return count(array_intersect($tags, $this->monitoredTags)) > 0;
    }

    /**
     * Get the list of tags currently being monitored.
     *
     * @return array
     */
    public function monitoring()
    {
        return $this->table('laravel_telescope_monitoring')->pluck('tag')->all();
    }

    /**
     * Begin monitoring the given list of tags.
     *
     * @return void
     */
    public function monitor(array $tags)
    {
        $tags = array_diff($tags, $this->monitoring());

        if (empty($tags)) {
            return;
        }

        $this->table('laravel_telescope_monitoring')
            ->insert(collect($tags)
                ->mapWithKeys(function ($tag) {
                    return ['tag' => $tag];
                })->all());
    }

    /**
     * Stop monitoring the given list of tags.
     *
     * @return void
     */
    public function stopMonitoring(array $tags)
    {
        $this->table('laravel_telescope_monitoring')->whereIn('tag', $tags)->delete();
    }

    /**
     * Prune all of the entries older than the given date.
     *
     * @param  bool  $keepExceptions
     * @return int
     */
    public function prune(DateTimeInterface $before, $keepExceptions)
    {
        $query = $this->table('laravel_telescope_entries')
            ->where('created_at', '<', $before);

        if ($keepExceptions) {
            $query->where('type', '!=', 'exception');
        }

        $totalDeleted = 0;

        do {
            $deleted = $query->take($this->chunkSize)->delete();

            $totalDeleted += $deleted;
        } while ($deleted !== 0);

        return $totalDeleted;
    }

    /**
     * Clear all the entries.
     *
     * @return void
     */
    public function clear()
    {
        do {
            $deleted = $this->table('laravel_telescope_entries')->take($this->chunkSize)->delete();
        } while ($deleted !== 0);

        do {
            $deleted = $this->table('laravel_telescope_monitoring')->take($this->chunkSize)->delete();
        } while ($deleted !== 0);
    }

    /**
     * Perform any clean-up tasks needed after storing Telescope entries.
     *
     * @return void
     */
    public function terminate()
    {
        $this->monitoredTags = null;
    }

    /**
     * Get a query builder instance for the given table.
     *
     * @param  string  $table
     * @return Builder
     */
    protected function table($table)
    {
        return DB::connection($this->connection)->table($table);
    }
}
