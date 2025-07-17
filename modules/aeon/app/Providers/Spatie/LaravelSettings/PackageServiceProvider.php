<?php

namespace Venture\Aeon\Providers\Spatie\LaravelSettings;

use Illuminate\Support\ServiceProvider;
use Spatie\LaravelSettings\LaravelSettingsServiceProvider;

class PackageServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->configurePackage();
        $this->configureProviders();
    }

    public function boot(): void {}

    protected function configurePackage(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../../../config/spatie/settings.php', 'settings'
        );
    }

    protected function configureProviders(): void
    {
        $this->app->register(LaravelSettingsServiceProvider::class);
    }
}
