<?php

namespace Venture\Alpha\Providers;

use Illuminate\Support\ServiceProvider;
use Venture\Aeon\Facades\Access;
use Venture\Alpha\Concerns\InteractsWithModule;
use Venture\Alpha\Enums\Auth\PermissionsEnum;
use Venture\Alpha\Enums\Auth\RolesEnum;

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
