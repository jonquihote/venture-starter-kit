<?php

namespace Venture\Alpha\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Venture\Alpha\Database\Factories\TeamFactory;
use Venture\Alpha\Enums\MigrationsEnum;
use Venture\Alpha\Models\Team\Events\TeamCreated;
use Venture\Alpha\Models\Team\Events\TeamCreating;
use Venture\Alpha\Models\Team\Events\TeamDeleted;
use Venture\Alpha\Models\Team\Events\TeamDeleting;
use Venture\Alpha\Models\Team\Events\TeamReplicating;
use Venture\Alpha\Models\Team\Events\TeamRetrieved;
use Venture\Alpha\Models\Team\Events\TeamSaved;
use Venture\Alpha\Models\Team\Events\TeamSaving;
use Venture\Alpha\Models\Team\Events\TeamUpdated;
use Venture\Alpha\Models\Team\Events\TeamUpdating;
use Venture\Alpha\Models\Team\Observers\TeamObserver;

#[UseFactory(TeamFactory::class)]
#[ObservedBy([TeamObserver::class])]
class Team extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'owner_id',

        'name',
        'slug',
    ];

    protected $dispatchesEvents = [
        'retrieved' => TeamRetrieved::class,
        'creating' => TeamCreating::class,
        'created' => TeamCreated::class,
        'updating' => TeamUpdating::class,
        'updated' => TeamUpdated::class,
        'saving' => TeamSaving::class,
        'saved' => TeamSaved::class,
        'deleting' => TeamDeleting::class,
        'deleted' => TeamDeleted::class,
        'replicating' => TeamReplicating::class,
    ];

    public function getTable(): string
    {
        return MigrationsEnum::Teams->table();
    }

    public function accounts(): BelongsToMany
    {
        return $this->belongsToMany(Account::class, Membership::class)
            ->withTimestamps()
            ->as('membership');
    }

    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'owner_id');
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }
}
