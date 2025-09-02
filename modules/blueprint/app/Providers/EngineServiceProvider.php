<?php

namespace Venture\Blueprint\Providers;

use Illuminate\Support\ServiceProvider;
use Venture\Blueprint\Concerns\InteractsWithModule;
use Venture\Blueprint\Filament\Pages\Dashboard;
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
            is_subscribed_by_default: true,
        ));
    }

    public function boot(): void {}
}
