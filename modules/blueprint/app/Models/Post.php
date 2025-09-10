<?php

namespace Venture\Blueprint\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Orbit\Concerns\Orbital;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Venture\Blueprint\Concerns\InteractsWithModule;
use Venture\Blueprint\Enums\DocumentationGroupsEnum;
use Venture\Blueprint\Filament\Clusters\Documentation\Resources\Posts\PostResource;
use Venture\Blueprint\Filament\Pages\ShowPost;
use Venture\Blueprint\Models\Post\Events\PostCreated;
use Venture\Blueprint\Models\Post\Events\PostCreating;
use Venture\Blueprint\Models\Post\Events\PostDeleted;
use Venture\Blueprint\Models\Post\Events\PostDeleting;
use Venture\Blueprint\Models\Post\Events\PostReplicating;
use Venture\Blueprint\Models\Post\Events\PostRetrieved;
use Venture\Blueprint\Models\Post\Events\PostSaved;
use Venture\Blueprint\Models\Post\Events\PostSaving;
use Venture\Blueprint\Models\Post\Events\PostUpdated;
use Venture\Blueprint\Models\Post\Events\PostUpdating;
use Venture\Blueprint\Models\Post\Observers\PostObserver;

#[ObservedBy([PostObserver::class])]
class Post extends Model implements Sortable
{
    use HasSlug;
    use InteractsWithModule;
    use Orbital;
    use SortableTrait;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'title',
        'content',

        'slug',
        'is_home_page',

        'documentation_group',
        'navigation_group',
        'navigation_sort',
    ];

    protected $dispatchesEvents = [
        'retrieved' => PostRetrieved::class,
        'creating' => PostCreating::class,
        'created' => PostCreated::class,
        'updating' => PostUpdating::class,
        'updated' => PostUpdated::class,
        'saving' => PostSaving::class,
        'saved' => PostSaved::class,
        'deleting' => PostDeleting::class,
        'deleted' => PostDeleted::class,
        'replicating' => PostReplicating::class,
    ];

    public array $sortable = [
        'order_column_name' => 'navigation_sort',
        'sort_when_creating' => true,
    ];

    public static function schema(Blueprint $table): void
    {
        $table->string('title');
        $table->text('content');

        $table->string('slug')->primary();
        $table->boolean('is_home_page');

        $table->string('documentation_group');
        $table->string('navigation_group')->nullable();
        $table->integer('navigation_sort');
    }

    protected function casts(): array
    {
        return [
            'documentation_group' => DocumentationGroupsEnum::class,
        ];
    }

    public function getKeyName(): string
    {
        return 'slug';
    }

    public static function getOrbitalPath(): string
    {
        return Collection::make([
            module_path('Blueprint', 'resources/orbit'),
            static::getOrbitalName(),
        ])->implode(DIRECTORY_SEPARATOR);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(function (Model $model) {
                $group = $model->documentation_group->slug();
                $title = Str::slug($model->title);

                return "{$group}-{$title}";
            })
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function getUrl(): string
    {
        return ShowPost::getUrl([$this]);
    }

    public function getEditUrl(): string
    {
        return PostResource::getUrl('edit', ['record' => $this]);
    }

    public function hasEditAccess(): bool
    {
        return auth()->user()->can('update', $this);
    }

    public function buildSortQuery(): Builder
    {
        return static::query()->where('documentation_group', $this->documentation_group);
    }
}
