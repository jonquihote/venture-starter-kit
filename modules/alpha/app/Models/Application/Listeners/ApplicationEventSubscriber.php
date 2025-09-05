<?php

namespace Venture\Alpha\Models\Application\Listeners;

use Illuminate\Events\Dispatcher;
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
use Venture\Alpha\Models\Subscription;
use Venture\Alpha\Settings\TenancySettings;

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
        $settings = app(TenancySettings::class);

        if ($settings->isSingleTeamMode() && $settings->defaultTeam()) {
            Subscription::firstOrCreate([
                'application_id' => $event->application->getKey(),
                'team_id' => $settings->defaultTeam()->getKey(),
            ]);
        }
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
