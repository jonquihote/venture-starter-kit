<?php

namespace Venture\Alpha\Models\Team\Listeners;

use Illuminate\Events\Dispatcher;
use InvalidArgumentException;
use Venture\Alpha\Models\Application;
use Venture\Alpha\Models\Subscription;
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
use Venture\Alpha\Settings\TenancySettings;

class TeamEventSubscriber
{
    public function handleTeamRetrieved(TeamRetrieved $event): void
    {
        //
    }

    public function handleTeamCreating(TeamCreating $event): void
    {
        $settings = app(TenancySettings::class);

        if ($settings->isSingleTeamMode()) {
            throw new InvalidArgumentException('Cannot create new teams when Single Team Mode is active.');
        }
    }

    public function handleTeamCreated(TeamCreated $event): void
    {
        Application::query()
            ->where('is_subscribed_by_default', true)
            ->each(function (Application $application) use ($event): void {
                Subscription::create([
                    'team_id' => $event->team->id,
                    'application_id' => $application->id,
                ]);
            });
    }

    public function handleTeamUpdating(TeamUpdating $event): void
    {
        //
    }

    public function handleTeamUpdated(TeamUpdated $event): void
    {
        //
    }

    public function handleTeamSaving(TeamSaving $event): void
    {
        //
    }

    public function handleTeamSaved(TeamSaved $event): void
    {
        //
    }

    public function handleTeamDeleting(TeamDeleting $event): void
    {
        $settings = app(TenancySettings::class);

        // Prevent ALL team deletion in Single Team Mode
        if ($settings->isSingleTeamMode()) {
            throw new InvalidArgumentException('Cannot delete teams when Single Team Mode is active.');
        }
    }

    public function handleTeamDeleted(TeamDeleted $event): void
    {
        //
    }

    public function handleTeamReplicating(TeamReplicating $event): void
    {
        //
    }

    public function subscribe(Dispatcher $events): array
    {
        return [
            TeamRetrieved::class => 'handleTeamRetrieved',
            TeamCreating::class => 'handleTeamCreating',
            TeamCreated::class => 'handleTeamCreated',
            TeamUpdating::class => 'handleTeamUpdating',
            TeamUpdated::class => 'handleTeamUpdated',
            TeamSaving::class => 'handleTeamSaving',
            TeamSaved::class => 'handleTeamSaved',
            TeamDeleting::class => 'handleTeamDeleting',
            TeamDeleted::class => 'handleTeamDeleted',
            TeamReplicating::class => 'handleTeamReplicating',
        ];
    }
}
