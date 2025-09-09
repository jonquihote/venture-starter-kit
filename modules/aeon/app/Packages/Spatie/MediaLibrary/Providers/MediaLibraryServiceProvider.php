<?php

namespace Venture\Aeon\Packages\Spatie\MediaLibrary\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Spatie\MediaLibrary\MediaLibraryServiceProvider as BaseMediaLibraryServiceProvider;

/**
 * @codeCoverageIgnore
 *
 * This file exists to accommodate `spatie_` prefixed database table & to customize configuration for Media Library.
 */
class MediaLibraryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->configurePackage();
        $this->configureProviders();
    }

    public function boot(): void {}

    protected function configurePackage(): void
    {
        $configPath = File::exists(config_path('media-library.php'))
            ? config_path('media-library.php')
            : __DIR__ . '/../../../../../config/spatie/media-library.php';

        $this->mergeConfigFrom($configPath, 'media-library');
    }

    protected function configureProviders(): void
    {
        $this->app->register(BaseMediaLibraryServiceProvider::class);
    }
}
