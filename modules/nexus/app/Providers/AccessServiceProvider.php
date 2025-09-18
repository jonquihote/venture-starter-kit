<?php

namespace Venture\Nexus\Providers;

use Illuminate\Support\ServiceProvider;
use Venture\Aeon\Facades\Access;
use Venture\Nexus\Concerns\InteractsWithModule;
use Venture\Nexus\Enums\Auth\PermissionsEnum;
use Venture\Nexus\Enums\Auth\RolesEnum;

class AccessServiceProvider extends ServiceProvider
{
    use InteractsWithModule;

    public function register(): void
    {
        Access::addPermissions(PermissionsEnum::all());
        Access::addRoles(RolesEnum::all());
        Access::addAdministratorRole(RolesEnum::Administrator);
    }

    public function boot(): void {}
}
