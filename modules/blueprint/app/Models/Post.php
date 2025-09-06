<?php

namespace Venture\Blueprint\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Orbit\Concerns\Orbital;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Venture\Blueprint\Concerns\InteractsWithModule;
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
class Post extends Model
{
    use HasSlug;
    use InteractsWithModule;
    use Orbital;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'is_home_page',
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

    public static function schema(Blueprint $table): void
    {
        $table->string('slug')->primary();
        $table->string('title');
        $table->text('content');
        $table->boolean('is_home_page')->default(false);
    }

    public static function getOrbitalPath(): string
    {
        return module_path('Blueprint', 'resources/orbit') . DIRECTORY_SEPARATOR . static::getOrbitalName();
    }

    public function getKeyName(): string
    {
        return 'slug';
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }
}
