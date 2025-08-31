<?php

namespace Venture\Aeon\Packages\FirstParty\Pulse\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Venture\Aeon\Enum\Auth\Permissions\PagePermissionsEnum;

class PulseApplicationServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Gate::define('viewPulse', function ($account = null): bool {
            return optional($account)->can(PagePermissionsEnum::PulseDashboard) ?? false;
        });
    }
}
