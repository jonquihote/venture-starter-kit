<?php

namespace Venture\Skeleton\Providers;

use Illuminate\Support\ServiceProvider;
use Venture\Aeon\Enums\ModulesEnum;
use Venture\Aeon\Support\Facades\Access;
use Venture\Skeleton\Enums\Auth\PermissionsEnum;
use Venture\Skeleton\Enums\Auth\RolesEnum;
use Venture\Skeleton\Filament\Pages\Dashboard;

class AccessServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Access::addPermissions(PermissionsEnum::all());
        Access::addRoles(RolesEnum::all());
        Access::addAdministratorRole(RolesEnum::ADMINISTRATOR);
        Access::addEntryPage(Dashboard::class, [
            'route' => 'filament.skeleton.pages.dashboard',
            'name' => ModulesEnum::SKELETON->name(),
            'slug' => ModulesEnum::SKELETON->slug(),
            'icon' => ModulesEnum::SKELETON->icon(),
        ]);
    }
}
