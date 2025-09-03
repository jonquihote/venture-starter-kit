<?php

namespace Venture\Omega\Providers;

use Illuminate\Support\ServiceProvider;
use Venture\Aeon\Facades\Access;
use Venture\Omega\Concerns\InteractsWithModule;
use Venture\Omega\Enums\Auth\PermissionsEnum;
use Venture\Omega\Enums\Auth\RolesEnum;

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
