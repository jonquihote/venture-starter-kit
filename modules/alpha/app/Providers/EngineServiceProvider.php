<?php

namespace Venture\Alpha\Providers;

use Illuminate\Support\ServiceProvider;
use Venture\Alpha\Concerns\InteractsWithModule;
use Venture\Alpha\Data\ApplicationData;
use Venture\Alpha\Facades\Engine;
use Venture\Alpha\Filament\Pages\Dashboard;

class EngineServiceProvider extends ServiceProvider
{
    use InteractsWithModule;

    public function register(): void
    {
        Engine::addApplication(new ApplicationData(
            $this->getModuleName(),
            Dashboard::class,
            $this->getModuleIcon(),
            is_subscribed_by_default: false,
        ));
    }

    public function boot(): void {}
}
