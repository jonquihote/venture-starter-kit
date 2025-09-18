<?php

namespace Venture\Sigma\Providers;

use Illuminate\Support\ServiceProvider;
use Venture\Alpha\Data\ApplicationData;
use Venture\Alpha\Facades\Engine;
use Venture\Sigma\Concerns\InteractsWithModule;
use Venture\Sigma\Filament\Pages\Dashboard;

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
