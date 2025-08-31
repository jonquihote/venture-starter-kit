<?php

namespace Venture\Aeon\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Venture\Aeon\Facades\Access;

class BootstrapAuthorizationCommand extends Command
{
    protected $signature = 'aeon:bootstrap:authorization';

    protected $description = 'Bootstrap authorization';

    public function handle(): void
    {
        $this->components->info('Registering Permissions.');

        Access::permissions()->each(function (string $permission): void {
            Permission::firstOrCreate([
                'name' => $permission,
            ]);

            $this->components->task($permission);
        });

        $this->components->info('Registering Roles.');

        Access::roles()->each(function (Collection $permissions, string $role): void {
            $instance = Role::firstOrCreate([
                'name' => $role,
            ]);

            $instance->syncPermissions($permissions);

            $this->components->task($role);
        });
    }
}
