<?php

namespace Venture\Home\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Venture\Home\Enums\MigrationsEnum;
use Venture\Home\Models\Subscription\Events\SubscriptionCreated;
use Venture\Home\Models\Subscription\Events\SubscriptionCreating;
use Venture\Home\Models\Subscription\Events\SubscriptionDeleted;
use Venture\Home\Models\Subscription\Events\SubscriptionDeleting;
use Venture\Home\Models\Subscription\Events\SubscriptionReplicating;
use Venture\Home\Models\Subscription\Events\SubscriptionRetrieved;
use Venture\Home\Models\Subscription\Events\SubscriptionSaved;
use Venture\Home\Models\Subscription\Events\SubscriptionSaving;
use Venture\Home\Models\Subscription\Events\SubscriptionUpdated;
use Venture\Home\Models\Subscription\Events\SubscriptionUpdating;
use Venture\Home\Models\Subscription\Observers\SubscriptionObserver;

#[ObservedBy([SubscriptionObserver::class])]
class Subscription extends Model
{
    protected $fillable = [
        'team_id',
        'application_id',
    ];

    protected $dispatchesEvents = [
        'retrieved' => SubscriptionRetrieved::class,
        'creating' => SubscriptionCreating::class,
        'created' => SubscriptionCreated::class,
        'updating' => SubscriptionUpdating::class,
        'updated' => SubscriptionUpdated::class,
        'saving' => SubscriptionSaving::class,
        'saved' => SubscriptionSaved::class,
        'deleting' => SubscriptionDeleting::class,
        'deleted' => SubscriptionDeleted::class,
        'replicating' => SubscriptionReplicating::class,
    ];

    public function getTable(): string
    {
        return MigrationsEnum::Subscriptions->table();
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
