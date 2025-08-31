<?php

namespace Venture\Aeon\Packages\FirstParty\Horizon\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider as BaseHorizonApplicationServiceProvider;
use Venture\Aeon\Enum\Auth\Permissions\PagePermissionsEnum;

class HorizonApplicationServiceProvider extends BaseHorizonApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();

        // Horizon::routeSmsNotificationsTo('15556667777');
        // Horizon::routeMailNotificationsTo('example@example.com');
        // Horizon::routeSlackNotificationsTo('slack-webhook-url', '#channel');
    }

    /**
     * Register the Horizon gate.
     *
     * This gate determines who can access Horizon in non-local environments.
     */
    protected function gate(): void
    {
        Gate::define('viewHorizon', function ($account = null): bool {
            return optional($account)->can(PagePermissionsEnum::HorizonDashboard) ?? false;
        });
    }
}
