<?php

namespace Venture\Home\Providers;

use Illuminate\Support\ServiceProvider;
use Venture\Aeon\Support\Facades\Access;
use Venture\Home\Enums\Auth\PermissionsEnum;
use Venture\Home\Enums\Auth\RolesEnum;

class AccessServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Access::addPermissions(PermissionsEnum::all());
        Access::addRoles(RolesEnum::all());
        Access::addAdministratorRole(RolesEnum::ADMINISTRATOR);
    }
}
