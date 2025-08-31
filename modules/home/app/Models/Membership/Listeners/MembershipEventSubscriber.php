<?php

namespace Venture\Home\Models\Membership\Listeners;

use Illuminate\Events\Dispatcher;
use Venture\Home\Models\Membership\Events\MembershipCreated;
use Venture\Home\Models\Membership\Events\MembershipCreating;
use Venture\Home\Models\Membership\Events\MembershipDeleted;
use Venture\Home\Models\Membership\Events\MembershipDeleting;
use Venture\Home\Models\Membership\Events\MembershipReplicating;
use Venture\Home\Models\Membership\Events\MembershipRetrieved;
use Venture\Home\Models\Membership\Events\MembershipSaved;
use Venture\Home\Models\Membership\Events\MembershipSaving;
use Venture\Home\Models\Membership\Events\MembershipUpdated;
use Venture\Home\Models\Membership\Events\MembershipUpdating;

class MembershipEventSubscriber
{
    public function handleMembershipRetrieved(MembershipRetrieved $event): void
    {
        //
    }

    public function handleMembershipCreating(MembershipCreating $event): void
    {
        //
    }

    public function handleMembershipCreated(MembershipCreated $event): void
    {
        //
    }

    public function handleMembershipUpdating(MembershipUpdating $event): void
    {
        //
    }

    public function handleMembershipUpdated(MembershipUpdated $event): void
    {
        //
    }

    public function handleMembershipSaving(MembershipSaving $event): void
    {
        //
    }

    public function handleMembershipSaved(MembershipSaved $event): void
    {
        //
    }

    public function handleMembershipDeleting(MembershipDeleting $event): void
    {
        //
    }

    public function handleMembershipDeleted(MembershipDeleted $event): void
    {
        //
    }

    public function handleMembershipReplicating(MembershipReplicating $event): void
    {
        //
    }

    public function subscribe(Dispatcher $events): array
    {
        return [
            MembershipRetrieved::class => 'handleMembershipRetrieved',
            MembershipCreating::class => 'handleMembershipCreating',
            MembershipCreated::class => 'handleMembershipCreated',
            MembershipUpdating::class => 'handleMembershipUpdating',
            MembershipUpdated::class => 'handleMembershipUpdated',
            MembershipSaving::class => 'handleMembershipSaving',
            MembershipSaved::class => 'handleMembershipSaved',
            MembershipDeleting::class => 'handleMembershipDeleting',
            MembershipDeleted::class => 'handleMembershipDeleted',
            MembershipReplicating::class => 'handleMembershipReplicating',
        ];
    }
}
