<?php

namespace Venture\Alpha\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Venture\Alpha\Models\Account\Listeners\AccountEventSubscriber;
use Venture\Alpha\Models\Application\Listeners\ApplicationEventSubscriber;
use Venture\Alpha\Models\Membership\Listeners\MembershipEventSubscriber;
use Venture\Alpha\Models\Subscription\Listeners\SubscriptionEventSubscriber;
use Venture\Alpha\Models\Team\Listeners\TeamEventSubscriber;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array<string, array<int, string>>
     */
    protected $listen = [
        //
    ];

    /**
     * The subscribers to register.
     *
     * @var array
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
