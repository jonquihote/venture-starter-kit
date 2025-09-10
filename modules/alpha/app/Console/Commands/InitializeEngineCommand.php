<?php

namespace Venture\Alpha\Console\Commands;

use Illuminate\Console\Command;
use Venture\Alpha\Data\ApplicationData;
use Venture\Alpha\Facades\Engine;
use Venture\Alpha\Models\Application;

/**
 * @codeCoverageIgnore
 */
class InitializeEngineCommand extends Command
{
    protected $signature = 'alpha:init:engine';

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
