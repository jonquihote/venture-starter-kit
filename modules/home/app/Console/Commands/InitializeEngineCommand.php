<?php

namespace Venture\Home\Console\Commands;

use Illuminate\Console\Command;
use Venture\Home\Data\ApplicationData;
use Venture\Home\Facades\Engine;
use Venture\Home\Models\Application;

class InitializeEngineCommand extends Command
{
    protected $signature = 'home:init:engine';

    protected $description = 'Initialize Applications';

    public function handle(): void
    {
        $this->components->info('Registering Applications.');

        Engine::applications()->each(function (ApplicationData $application): void {
            Application::firstOrCreate([
                'name' => $application->name,
                'page' => $application->page,
                'icon' => $application->icon,

                'is_subscribed_by_default' => $application->is_subscribed_by_default,
            ]);

            $this->components->task($application->name);
        });
    }
}
