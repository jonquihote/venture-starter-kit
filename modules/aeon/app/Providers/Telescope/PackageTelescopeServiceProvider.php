<?php

namespace Venture\Aeon\Providers\Telescope;

use Illuminate\Support\ServiceProvider;
use Laravel\Telescope\Contracts\ClearableRepository;
use Laravel\Telescope\Contracts\EntriesRepository;
use Laravel\Telescope\Contracts\PrunableRepository;
use Laravel\Telescope\TelescopeServiceProvider as BaseTelescopeServiceProvider;
use Venture\Aeon\Packages\FirstParty\Telescope\Storage\DatabaseEntriesRepository;

class PackageTelescopeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->configureTelescope();
        $this->configureProviders();
        $this->configureBindings();
    }

    public function boot(): void {}

    protected function configureTelescope(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../../config/package/telescope.php', 'telescope'
        );
    }

    protected function configureProviders(): void
    {
        $this->app->register(BaseTelescopeServiceProvider::class);
        $this->app->register(TelescopeServiceProvider::class);
    }

    protected function configureBindings(): void
    {
        $this->app->singleton(
            EntriesRepository::class, DatabaseEntriesRepository::class
        );

        $this->app->singleton(
            ClearableRepository::class, DatabaseEntriesRepository::class
        );

        $this->app->singleton(
            PrunableRepository::class, DatabaseEntriesRepository::class
        );

        $this->app->when(DatabaseEntriesRepository::class)
            ->needs('$connection')
            ->give(config('telescope.storage.database.connection'));

        $this->app->when(DatabaseEntriesRepository::class)
            ->needs('$chunkSize')
            ->give(config('telescope.storage.database.chunk'));
    }
}
