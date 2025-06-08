<?php

namespace Venture\Aeon\Actions;

use Illuminate\Console\View\Components\Factory as Component;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Action;
use Venture\Aeon\Models\Permission;
use Venture\Aeon\Models\Role;
use Venture\Aeon\Support\Facades\Access;

class InitializeAuthorization extends Action
{
    public function handle(Component $component)
    {
        $component->info('Registering Permissions.');

        Access::permissions()->each(function (string $permission) use ($component) {
            Permission::create([
                'name' => $permission,
            ]);

            $component->task($permission);
        });

        $component->info('Registering Roles.');

        Access::roles()->each(function (Collection $permissions, string $role) use ($component) {
            $instance = Role::create([
                'name' => $role,
            ]);

            $instance->syncPermissions($permissions);

            $component->task($role);
        });
    }
}
