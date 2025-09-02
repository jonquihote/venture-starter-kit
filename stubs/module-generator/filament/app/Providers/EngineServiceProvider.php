<?php

namespace Venture\{Module}\Providers;

use Illuminate\Support\ServiceProvider;
use Venture\{Module}\Concerns\InteractsWithModule;
use Venture\{Module}\Filament\Pages\Dashboard;
use Venture\Alpha\Data\ApplicationData;
use Venture\Alpha\Facades\Engine;

class EngineServiceProvider extends ServiceProvider
{
    use InteractsWithModule;

    public function register(): void
    {
        Engine::addApplication(new ApplicationData(
            $this->getModuleName(),
            Dashboard::class,
            $this->getModuleIcon(),
            is_subscribed_by_default: true,
        ));
    }

    public function boot(): void {}
}
