<?php

namespace Venture\Home\Models\Application\Listeners;

use Illuminate\Events\Dispatcher;
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

class ApplicationEventSubscriber
{
    public function handleApplicationRetrieved(ApplicationRetrieved $event): void
    {
        //
    }

    public function handleApplicationCreating(ApplicationCreating $event): void
    {
        //
    }

    public function handleApplicationCreated(ApplicationCreated $event): void
    {
        //
    }

    public function handleApplicationUpdating(ApplicationUpdating $event): void
    {
        //
    }

    public function handleApplicationUpdated(ApplicationUpdated $event): void
    {
        //
    }

    public function handleApplicationSaving(ApplicationSaving $event): void
    {
        //
    }

    public function handleApplicationSaved(ApplicationSaved $event): void
    {
        //
    }

    public function handleApplicationDeleting(ApplicationDeleting $event): void
    {
        //
    }

    public function handleApplicationDeleted(ApplicationDeleted $event): void
    {
        //
    }

    public function handleApplicationReplicating(ApplicationReplicating $event): void
    {
        //
    }

    public function subscribe(Dispatcher $events): array
    {
        return [
            ApplicationRetrieved::class => 'handleApplicationRetrieved',
            ApplicationCreating::class => 'handleApplicationCreating',
            ApplicationCreated::class => 'handleApplicationCreated',
            ApplicationUpdating::class => 'handleApplicationUpdating',
            ApplicationUpdated::class => 'handleApplicationUpdated',
            ApplicationSaving::class => 'handleApplicationSaving',
            ApplicationSaved::class => 'handleApplicationSaved',
            ApplicationDeleting::class => 'handleApplicationDeleting',
            ApplicationDeleted::class => 'handleApplicationDeleted',
            ApplicationReplicating::class => 'handleApplicationReplicating',
        ];
    }
}
