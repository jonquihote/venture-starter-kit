<?php

namespace Venture\Aeon\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Venture\Aeon\Facades\Access;

class InitializeAccessCommand extends Command
{
    protected $signature = 'aeon:init:access';

    protected $description = 'Initialize Roles & Permissions';

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
