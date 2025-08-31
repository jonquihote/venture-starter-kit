<?php

namespace Venture\Aeon\Packages\FirstParty\Pulse\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Laravel\Pulse\Contracts\Storage;
use Laravel\Pulse\PulseServiceProvider as BasePulseServiceProvider;
use Venture\Aeon\Packages\FirstParty\Pulse\Storage\DatabaseStorage;

class PulseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->configurePackage();
        $this->configureProviders();
        $this->configureStorage();
    }

    public function boot(): void {}

    protected function configurePackage(): void
    {
        $configPath = File::exists(config_path('pulse.php'))
            ? config_path('pulse.php')
            : __DIR__ . '/../../../../../config/laravel/pulse.php';

        $this->mergeConfigFrom($configPath, 'pulse');
    }

    protected function configureProviders(): void
    {
        $this->app->register(BasePulseServiceProvider::class);
        $this->app->register(PulseApplicationServiceProvider::class);
    }

    protected function configureStorage(): void
    {
        $this->app->bind(Storage::class, DatabaseStorage::class);
    }
}
