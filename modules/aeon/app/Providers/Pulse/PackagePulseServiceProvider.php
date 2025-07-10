<?php

namespace Venture\Aeon\Providers\Pulse;

use Illuminate\Support\ServiceProvider;
use Laravel\Pulse\Contracts\Storage;
use Laravel\Pulse\PulseServiceProvider as BasePulseServiceProvider;
use Venture\Aeon\Packages\FirstParty\Pulse\Storage\DatabaseStorage;

class PackagePulseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->configurePulse();
        $this->configureProviders();
        $this->configureBindings();
    }

    public function boot(): void {}

    protected function configurePulse(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../../config/package/pulse.php', 'pulse'
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
