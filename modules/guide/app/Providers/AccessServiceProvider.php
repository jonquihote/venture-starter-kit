<?php

namespace Venture\Guide\Providers;

use Illuminate\Support\ServiceProvider;
use Venture\Aeon\Enums\ModulesEnum;
use Venture\Aeon\Support\Facades\Access;
use Venture\Guide\Enums\Auth\PermissionsEnum;
use Venture\Guide\Enums\Auth\RolesEnum;
use Venture\Guide\Filament\Pages\Dashboard;

class AccessServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Access::addPermissions(PermissionsEnum::all());
        Access::addRoles(RolesEnum::all());
        Access::addAdministratorRole(RolesEnum::ADMINISTRATOR);
        Access::addEntryPage(Dashboard::class, [
            'route' => 'filament.guide.pages.dashboard',
            'name' => ModulesEnum::GUIDE->name(),
            'slug' => ModulesEnum::GUIDE->slug(),
            'icon' => ModulesEnum::GUIDE->icon(),
        ]);
    }
}
