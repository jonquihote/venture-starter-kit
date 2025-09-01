<?php

namespace Venture\{Module}\Providers;

use Illuminate\Support\ServiceProvider;
use Venture\{Module}\Concerns\InteractsWithModule;
use Venture\{Module}\Filament\Pages\Dashboard;
use Venture\Home\Data\ApplicationData;
use Venture\Home\Facades\Engine;

class EngineServiceProvider extends ServiceProvider
{
    use InteractsWithModule;

    public function register(): void
    {
        Engine::addApplication(new ApplicationData(
            $this->getModuleName(),
            Dashboard::class,
            $this->getModuleIcon(),
        ));
    }

    public function boot(): void {}
}