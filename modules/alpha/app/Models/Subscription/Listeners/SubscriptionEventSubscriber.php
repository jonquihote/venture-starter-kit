<?php

namespace Venture\Alpha\Models\Subscription\Listeners;

use Illuminate\Events\Dispatcher;
use Venture\Alpha\Actions\AssignTeamOwnerRole;
use Venture\Alpha\Actions\InitializeTeamAccess;
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

class SubscriptionEventSubscriber
{
    public function handleSubscriptionRetrieved(SubscriptionRetrieved $event): void
    {
        //
    }

    public function handleSubscriptionCreating(SubscriptionCreating $event): void
    {
        //
    }

    public function handleSubscriptionCreated(SubscriptionCreated $event): void
    {
        InitializeTeamAccess::run($event->subscription);
        AssignTeamOwnerRole::run($event->subscription);
    }

    public function handleSubscriptionUpdating(SubscriptionUpdating $event): void
    {
        //
    }

    public function handleSubscriptionUpdated(SubscriptionUpdated $event): void
    {
        //
    }

    public function handleSubscriptionSaving(SubscriptionSaving $event): void
    {
        //
    }

    public function handleSubscriptionSaved(SubscriptionSaved $event): void
    {
        //
    }

    public function handleSubscriptionDeleting(SubscriptionDeleting $event): void
    {
        //
    }

    public function handleSubscriptionDeleted(SubscriptionDeleted $event): void
    {
        //
    }

    public function handleSubscriptionReplicating(SubscriptionReplicating $event): void
    {
        //
    }

    public function subscribe(Dispatcher $events): array
    {
        return [
            SubscriptionRetrieved::class => 'handleSubscriptionRetrieved',
            SubscriptionCreating::class => 'handleSubscriptionCreating',
            SubscriptionCreated::class => 'handleSubscriptionCreated',
            SubscriptionUpdating::class => 'handleSubscriptionUpdating',
            SubscriptionUpdated::class => 'handleSubscriptionUpdated',
            SubscriptionSaving::class => 'handleSubscriptionSaving',
            SubscriptionSaved::class => 'handleSubscriptionSaved',
            SubscriptionDeleting::class => 'handleSubscriptionDeleting',
            SubscriptionDeleted::class => 'handleSubscriptionDeleted',
            SubscriptionReplicating::class => 'handleSubscriptionReplicating',
        ];
    }
}
