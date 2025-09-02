<?php

namespace Venture\Alpha\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Venture\Alpha\Database\Factories\SubscriptionFactory;
use Venture\Alpha\Enums\MigrationsEnum;
use Venture\Alpha\Models\Subscription\Events\SubscriptionCreated;
use Venture\Alpha\Models\Subscription\Events\SubscriptionCreating;
use Venture\Alpha\Models\Subscription\Events\SubscriptionDeleted;
use Venture\Alpha\Models\Subscription\Events\SubscriptionDeleting;
use Venture\Alpha\Models\Subscription\Events\SubscriptionReplicating;
use Venture\Alpha\Models\Subscription\Events\SubscriptionRetrieved;
use Venture\Alpha\Models\Subscription\Events\SubscriptionSaved;
use Venture\Alpha\Models\Subscription\Events\SubscriptionSaving;
use Venture\Alpha\Models\Subscription\Events\SubscriptionUpdated;
use Venture\Alpha\Models\Subscription\Events\SubscriptionUpdating;
use Venture\Alpha\Models\Subscription\Observers\SubscriptionObserver;

#[UseFactory(SubscriptionFactory::class)]
#[ObservedBy([SubscriptionObserver::class])]
class Subscription extends Model
{
    use HasFactory;

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
