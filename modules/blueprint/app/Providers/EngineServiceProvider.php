<?php

namespace Venture\Blueprint\Providers;

use Illuminate\Support\ServiceProvider;
use Venture\Alpha\Data\ApplicationData;
use Venture\Alpha\Facades\Engine;
use Venture\Blueprint\Concerns\InteractsWithModule;
use Venture\Blueprint\Filament\Pages\Home;

class EngineServiceProvider extends ServiceProvider
{
    use InteractsWithModule;

    public function register(): void
    {
        Engine::addApplication(new ApplicationData(
            $this->getModuleName(),
            Home::class,
            $this->getModuleIcon(),
            is_subscribed_by_default: true,
        ));
    }

    public function boot(): void {}
}
