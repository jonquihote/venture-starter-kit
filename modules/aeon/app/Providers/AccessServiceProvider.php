<?php

namespace Venture\Aeon\Providers;

use Illuminate\Support\ServiceProvider;
use Venture\Aeon\Enum\Auth\PermissionsEnum;
use Venture\Aeon\Enum\Auth\RolesEnum;
use Venture\Aeon\Facades\Access;

class AccessServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Access::addPermissions(PermissionsEnum::all());
        Access::addRoles(RolesEnum::all());
        Access::addAdministratorRole(RolesEnum::Administrator);
    }

    public function boot(): void {}
}
