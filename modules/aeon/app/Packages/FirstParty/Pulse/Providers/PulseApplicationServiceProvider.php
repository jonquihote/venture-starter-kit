<?php

namespace Venture\Aeon\Packages\FirstParty\Pulse\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Venture\Alpha\Enums\Auth\Permissions\PagePermissionsEnum;

/**
 * @codeCoverageIgnore
 *
 * This file exists to accommodate custom permissions feature to access the Dashboard & to customize configuration for Pulse Dashboard
 */
class PulseApplicationServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Gate::define('viewPulse', function ($account = null): bool {
            setPermissionsTeamId($account->current_team_id);

            return optional($account)->can(PagePermissionsEnum::PulseDashboard) ?? false;
        });
    }
}
