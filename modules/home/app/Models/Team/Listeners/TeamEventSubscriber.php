<?php

namespace Venture\Home\Models\Team\Listeners;

use Illuminate\Events\Dispatcher;
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

class TeamEventSubscriber
{
    public function handleTeamRetrieved(TeamRetrieved $event): void
    {
        //
    }

    public function handleTeamCreating(TeamCreating $event): void
    {
        //
    }

    public function handleTeamCreated(TeamCreated $event): void
    {
        //
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
        //
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
