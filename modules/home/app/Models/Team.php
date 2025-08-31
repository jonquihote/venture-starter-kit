<?php

namespace Venture\Home\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Sprout\Contracts\Tenant;
use Sprout\Database\Eloquent\Concerns\IsTenant;
use Venture\Home\Database\Factories\TeamFactory;
use Venture\Home\Enums\MigrationsEnum;
use Venture\Home\Models\Team\Events\TeamCreated;
use Venture\Home\Models\Team\Events\TeamCreating;
use Venture\Home\Models\Team\Events\TeamDeleted;
use Venture\Home\Models\Team\Events\TeamDeleting;
use Venture\Home\Models\Team\Events\TeamReplicating;
use Venture\Home\Models\Team\Events\TeamRetrieved;
use Venture\Home\Models\Team\Events\TeamSaved;
use Venture\Home\Models\Team\Events\TeamSaving;
use Venture\Home\Models\Team\Events\TeamUpdated;
use Venture\Home\Models\Team\Events\TeamUpdating;
use Venture\Home\Models\Team\Observers\TeamObserver;

#[UseFactory(TeamFactory::class)]
#[ObservedBy([TeamObserver::class])]
class Team extends Model implements Tenant
{
    use HasFactory;
    use HasSlug;
    use IsTenant;

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
