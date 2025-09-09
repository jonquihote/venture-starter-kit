<?php

namespace Venture\Aeon\Packages\FirstParty\Telescope\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Laravel\Telescope\Contracts\ClearableRepository;
use Laravel\Telescope\Contracts\EntriesRepository;
use Laravel\Telescope\Contracts\PrunableRepository;
use Laravel\Telescope\TelescopeServiceProvider as BaseTelescopeServiceProvider;
use Venture\Aeon\Packages\FirstParty\Telescope\Storage\DatabaseEntriesRepository;

/**
 * @codeCoverageIgnore
 *
 * This file exists to accommodate custom permissions feature to access the Dashboard & to customize configuration for Telescope Dashboard
 */
class TelescopeServiceProvider extends ServiceProvider
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
        $configPath = File::exists(config_path('telescope.php'))
            ? config_path('telescope.php')
            : __DIR__ . '/../../../../../config/laravel/telescope.php';

        $this->mergeConfigFrom($configPath, 'telescope');
    }

    protected function configureProviders(): void
    {
        $this->app->register(BaseTelescopeServiceProvider::class);
        $this->app->register(TelescopeApplicationServiceProvider::class);
    }

    protected function configureBindings(): void
    {
        $this->app->singleton(
            EntriesRepository::class,
            DatabaseEntriesRepository::class
        );

        $this->app->singleton(
            ClearableRepository::class,
            DatabaseEntriesRepository::class
        );

        $this->app->singleton(
            PrunableRepository::class,
            DatabaseEntriesRepository::class
        );

        $this->app->when(DatabaseEntriesRepository::class)
            ->needs('$connection')
            ->give(config('telescope.storage.database.connection'));

        $this->app->when(DatabaseEntriesRepository::class)
            ->needs('$chunkSize')
            ->give(config('telescope.storage.database.chunk'));
    }
}
