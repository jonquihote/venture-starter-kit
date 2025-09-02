<?php

namespace Venture\Home\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Venture\Home\Models\Account\Listeners\AccountEventSubscriber;
use Venture\Home\Models\Application\Listeners\ApplicationEventSubscriber;
use Venture\Home\Models\Membership\Listeners\MembershipEventSubscriber;
use Venture\Home\Models\Subscription\Listeners\SubscriptionEventSubscriber;
use Venture\Home\Models\Team\Listeners\TeamEventSubscriber;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array<string, array<int, string>>
     */
    protected $listen = [];

    /**
     * The subscriber classes to register.
     *
     * @var array<int, string>
     */
    protected $subscribe = [
        AccountEventSubscriber::class,
        TeamEventSubscriber::class,
        ApplicationEventSubscriber::class,
        SubscriptionEventSubscriber::class,
        MembershipEventSubscriber::class,
    ];

    /**
     * Indicates if events should be discovered.
     *
     * @var bool
     */
    protected static $shouldDiscoverEvents = true;

    /**
     * Configure the proper event listeners for email verification.
     */
    protected function configureEmailVerification(): void {}
}
