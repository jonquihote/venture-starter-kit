<?php

namespace Venture\Aeon\Providers\Laravel\Pulse;

use Illuminate\Support\ServiceProvider;
use Laravel\Pulse\Contracts\Storage;
use Laravel\Pulse\PulseServiceProvider as BasePulseServiceProvider;
use Venture\Aeon\Packages\Laravel\Pulse\Storage\DatabaseStorage;

class PackageServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->configurePackage();
        $this->configureProviders();
        $this->configureBindings();
    }

    public function boot(): void {}

    protected function configurePackage(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../../../config/laravel/pulse.php', 'pulse'
        );
    }

    protected function configureProviders(): void
    {
        $this->app->register(BasePulseServiceProvider::class);
        $this->app->register(PulseServiceProvider::class);
    }

    protected function configureBindings(): void
    {
        $this->app->bind(Storage::class, DatabaseStorage::class);
    }
}
