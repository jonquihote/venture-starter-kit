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
            Dashboard::class,
            $this->getModuleName(),
            $this->getModuleSlug(),
            $this->getModuleIcon(),
        ));
    }

    public function boot(): void {}
}
