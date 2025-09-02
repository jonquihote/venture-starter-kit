<?php

namespace Venture\Alpha\Models\Account\Listeners;

use Illuminate\Events\Dispatcher;
use Venture\Alpha\Models\Account\Events\AccountCreated;
use Venture\Alpha\Models\Account\Events\AccountCreating;
use Venture\Alpha\Models\Account\Events\AccountDeleted;
use Venture\Alpha\Models\Account\Events\AccountDeleting;
use Venture\Alpha\Models\Account\Events\AccountReplicating;
use Venture\Alpha\Models\Account\Events\AccountRetrieved;
use Venture\Alpha\Models\Account\Events\AccountSaved;
use Venture\Alpha\Models\Account\Events\AccountSaving;
use Venture\Alpha\Models\Account\Events\AccountUpdated;
use Venture\Alpha\Models\Account\Events\AccountUpdating;

class AccountEventSubscriber
{
    public function handleAccountRetrieved(AccountRetrieved $event): void
    {
        //
    }

    public function handleAccountCreating(AccountCreating $event): void
    {
        //
    }

    public function handleAccountCreated(AccountCreated $event): void
    {
        //
    }

    public function handleAccountUpdating(AccountUpdating $event): void
    {
        //
    }

    public function handleAccountUpdated(AccountUpdated $event): void
    {
        //
    }

    public function handleAccountSaving(AccountSaving $event): void
    {
        //
    }

    public function handleAccountSaved(AccountSaved $event): void
    {
        //
    }

    public function handleAccountDeleting(AccountDeleting $event): void
    {
        //
    }

    public function handleAccountDeleted(AccountDeleted $event): void
    {
        //
    }

    public function handleAccountReplicating(AccountReplicating $event): void
    {
        //
    }

    public function subscribe(Dispatcher $events): array
    {
        return [
            AccountRetrieved::class => 'handleAccountRetrieved',
            AccountCreating::class => 'handleAccountCreating',
            AccountCreated::class => 'handleAccountCreated',
            AccountUpdating::class => 'handleAccountUpdating',
            AccountUpdated::class => 'handleAccountUpdated',
            AccountSaving::class => 'handleAccountSaving',
            AccountSaved::class => 'handleAccountSaved',
            AccountDeleting::class => 'handleAccountDeleting',
            AccountDeleted::class => 'handleAccountDeleted',
            AccountReplicating::class => 'handleAccountReplicating',
        ];
    }
}
