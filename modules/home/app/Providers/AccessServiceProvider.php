<?php

namespace Venture\Home\Providers;

use Illuminate\Support\ServiceProvider;
use Venture\Aeon\Facades\Access;
use Venture\Home\Enums\Auth\PermissionsEnum;
use Venture\Home\Enums\Auth\RolesEnum;

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
