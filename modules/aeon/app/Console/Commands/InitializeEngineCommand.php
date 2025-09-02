<?php

namespace Venture\Aeon\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Venture\Aeon\Facades\Access;

class InitializeEngineCommand extends Command
{
    protected $signature = 'aeon:init:engine';

    protected $description = 'Initialize Engine Permissions';

    public function handle(): void
    {
        $this->components->info('Registering Permissions.');

        Access::permissions()->each(function (string $permission): void {
            Permission::firstOrCreate([
                'name' => $permission,
            ]);

            $this->components->task($permission);
        });
    }
}
