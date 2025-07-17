<?php

namespace Venture\Aeon\Providers\Laravel\Horizon;

use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\HorizonServiceProvider as BaseHorizonServiceProvider;

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
            __DIR__ . '/../../../../config/laravel/horizon.php', 'horizon'
        );
    }

    protected function configureProviders(): void
    {
        $this->app->register(BaseHorizonServiceProvider::class);
        $this->app->register(HorizonServiceProvider::class);
    }
}
