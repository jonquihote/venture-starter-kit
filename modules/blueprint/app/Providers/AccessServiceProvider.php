<?php

namespace Venture\Blueprint\Providers;

use Illuminate\Support\ServiceProvider;
use Venture\Aeon\Facades\Access;
use Venture\Blueprint\Enums\Auth\PermissionsEnum;
use Venture\Blueprint\Enums\Auth\RolesEnum;

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
