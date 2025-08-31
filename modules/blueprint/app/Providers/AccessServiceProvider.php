<?php

namespace Venture\Blueprint\Providers;

use Illuminate\Support\ServiceProvider;
use Venture\Aeon\Data\ApplicationData;
use Venture\Aeon\Facades\Access;
use Venture\Blueprint\Concerns\InteractsWithModule;
use Venture\Blueprint\Enums\Auth\PermissionsEnum;
use Venture\Blueprint\Enums\Auth\RolesEnum;
use Venture\Blueprint\Filament\Pages\Dashboard;

class AccessServiceProvider extends ServiceProvider
{
    use InteractsWithModule;

    public function register(): void
    {
        Access::addPermissions(PermissionsEnum::all());
        Access::addRoles(RolesEnum::all());
        Access::addAdministratorRole(RolesEnum::Administrator);
        Access::addApplication(new ApplicationData(
            Dashboard::class,
            $this->getModuleName(),
            $this->getModuleSlug(),
            $this->getModuleIcon(),
        ));
    }

    public function boot(): void {}
}
