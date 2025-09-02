<?php

namespace Venture\Alpha\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Venture\Alpha\Database\Factories\ApplicationFactory;
use Venture\Alpha\Enums\MigrationsEnum;
use Venture\Alpha\Models\Application\Events\ApplicationCreated;
use Venture\Alpha\Models\Application\Events\ApplicationCreating;
use Venture\Alpha\Models\Application\Events\ApplicationDeleted;
use Venture\Alpha\Models\Application\Events\ApplicationDeleting;
use Venture\Alpha\Models\Application\Events\ApplicationReplicating;
use Venture\Alpha\Models\Application\Events\ApplicationRetrieved;
use Venture\Alpha\Models\Application\Events\ApplicationSaved;
use Venture\Alpha\Models\Application\Events\ApplicationSaving;
use Venture\Alpha\Models\Application\Events\ApplicationUpdated;
use Venture\Alpha\Models\Application\Events\ApplicationUpdating;
use Venture\Alpha\Models\Application\Observers\ApplicationObserver;

#[UseFactory(ApplicationFactory::class)]
#[ObservedBy([ApplicationObserver::class])]
class Application extends Model
{
    use HasFactory;
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
