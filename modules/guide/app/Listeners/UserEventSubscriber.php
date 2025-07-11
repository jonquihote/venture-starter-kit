<?php

namespace Venture\Guide\Listeners;

use Illuminate\Events\Dispatcher;
use Venture\Home\Events\Models\UserEvent\UserCreatedEvent;
use Venture\Home\Events\Models\UserEvent\UserDeletedEvent;
use Venture\Home\Events\Models\UserEvent\UserUpdatedEvent;

class UserEventSubscriber
{
    public function subscribe(Dispatcher $events): array
    {
        return [
            UserCreatedEvent::class => 'handleUserCreated',
            UserUpdatedEvent::class => 'handleUserUpdated',
            UserDeletedEvent::class => 'handleUserDeleted',
        ];
    }

    public function handleUserCreated(UserCreatedEvent $event): void
    {
        //
    }

    public function handleUserUpdated(UserUpdatedEvent $event): void
    {
        //
    }

    public function handleUserDeleted(UserDeletedEvent $event): void
    {
        //
    }
}
