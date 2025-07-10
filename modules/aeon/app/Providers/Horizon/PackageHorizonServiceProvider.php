<?php

namespace Venture\Aeon\Providers\Horizon;

use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\HorizonServiceProvider as BaseHorizonServiceProvider;

class PackageHorizonServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->configureHorizon();
        $this->configureProviders();
    }

    public function boot(): void {}

    protected function configureHorizon(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../../config/package/horizon.php', 'horizon'
        );
    }

    protected function configureProviders(): void
    {
        $this->app->register(BaseHorizonServiceProvider::class);
        $this->app->register(HorizonServiceProvider::class);
    }
}
