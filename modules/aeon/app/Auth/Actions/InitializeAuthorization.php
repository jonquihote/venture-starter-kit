<?php

namespace Venture\Aeon\Auth\Actions;

use Illuminate\Console\View\Components\Factory as Component;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Action;
use Venture\Aeon\Packages\Spatie\Permissions\Permission;
use Venture\Aeon\Packages\Spatie\Permissions\Role;
use Venture\Aeon\Support\Facades\Access;

class InitializeAuthorization extends Action
{
    public function handle(Component $component)
    {
        $component->info('Registering Permissions.');

        Access::permissions()->each(function (string $permission) use ($component): void {
            Permission::firstOrCreate([
                'name' => $permission,
            ]);

            $component->task($permission);
        });

        $component->info('Registering Roles.');

        Access::roles()->each(function (Collection $permissions, string $role) use ($component): void {
            $instance = Role::firstOrCreate([
                'name' => $role,
            ]);

            $instance->syncPermissions($permissions);

            $component->task($role);
        });
    }
}
