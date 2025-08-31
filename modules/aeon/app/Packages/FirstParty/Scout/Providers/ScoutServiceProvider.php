<?php

namespace Venture\Aeon\Packages\FirstParty\Scout\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Laravel\Scout\ScoutServiceProvider as BaseScoutServiceProvider;

class ScoutServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->configurePackage();
        $this->configureProviders();
    }

    public function boot(): void {}

    protected function configurePackage(): void
    {
        $configPath = File::exists(config_path('scout.php'))
            ? config_path('scout.php')
            : __DIR__ . '/../../../../../config/laravel/scout.php';

        $this->mergeConfigFrom($configPath, 'scout');
    }

    protected function configureProviders(): void
    {
        $this->app->register(BaseScoutServiceProvider::class);
    }
}
