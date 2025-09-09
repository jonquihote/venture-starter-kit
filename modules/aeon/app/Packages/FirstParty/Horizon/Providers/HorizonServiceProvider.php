<?php

namespace Venture\Aeon\Packages\FirstParty\Horizon\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\HorizonServiceProvider as BaseHorizonServiceProvider;

/**
 * @codeCoverageIgnore
 *
 * This file exists to accommodate custom permissions feature to access the Dashboard & to customize configuration for Horizon Dashboard
 */
class HorizonServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->configurePackage();
        $this->configureProviders();
    }

    public function boot(): void {}

    protected function configurePackage(): void
    {
        $configPath = File::exists(config_path('horizon.php'))
            ? config_path('horizon.php')
            : __DIR__ . '/../../../../../config/laravel/horizon.php';

        $this->mergeConfigFrom($configPath, 'horizon');
    }

    protected function configureProviders(): void
    {
        $this->app->register(BaseHorizonServiceProvider::class);
        $this->app->register(HorizonApplicationServiceProvider::class);
    }
}
