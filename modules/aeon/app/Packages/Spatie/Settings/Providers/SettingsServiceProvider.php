<?php

namespace Venture\Aeon\Packages\Spatie\Settings\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Spatie\LaravelSettings\LaravelSettingsServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->configurePackage();
        $this->configureProviders();
    }

    public function boot(): void {}

    protected function configurePackage(): void
    {
        $configPath = File::exists(config_path('settings.php'))
            ? config_path('settings.php')
            : __DIR__ . '/../../../../../config/spatie/settings.php';

        $this->mergeConfigFrom($configPath, 'settings');
    }

    protected function configureProviders(): void
    {
        $this->app->register(LaravelSettingsServiceProvider::class);
    }
}
