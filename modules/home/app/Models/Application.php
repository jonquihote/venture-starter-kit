<?php

namespace Venture\Home\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Venture\Home\Enums\MigrationsEnum;
use Venture\Home\Models\Application\Events\ApplicationCreated;
use Venture\Home\Models\Application\Events\ApplicationCreating;
use Venture\Home\Models\Application\Events\ApplicationDeleted;
use Venture\Home\Models\Application\Events\ApplicationDeleting;
use Venture\Home\Models\Application\Events\ApplicationReplicating;
use Venture\Home\Models\Application\Events\ApplicationRetrieved;
use Venture\Home\Models\Application\Events\ApplicationSaved;
use Venture\Home\Models\Application\Events\ApplicationSaving;
use Venture\Home\Models\Application\Events\ApplicationUpdated;
use Venture\Home\Models\Application\Events\ApplicationUpdating;
use Venture\Home\Models\Application\Observers\ApplicationObserver;

#[ObservedBy([ApplicationObserver::class])]
class Application extends Model
{
    use HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'page',
        'icon',

        'is_subscribed_by_default',
    ];

    protected $dispatchesEvents = [
        'retrieved' => ApplicationRetrieved::class,
        'creating' => ApplicationCreating::class,
        'created' => ApplicationCreated::class,
        'updating' => ApplicationUpdating::class,
        'updated' => ApplicationUpdated::class,
        'saving' => ApplicationSaving::class,
        'saved' => ApplicationSaved::class,
        'deleting' => ApplicationDeleting::class,
        'deleted' => ApplicationDeleted::class,
        'replicating' => ApplicationReplicating::class,
    ];

    public function getTable(): string
    {
        return MigrationsEnum::Applications->table();
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }
}
