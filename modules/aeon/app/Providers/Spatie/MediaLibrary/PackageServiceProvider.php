<?php

namespace Venture\Aeon\Providers\Spatie\MediaLibrary;

use Illuminate\Support\ServiceProvider;
use Spatie\MediaLibrary\MediaLibraryServiceProvider;

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
            __DIR__ . '/../../../../config/spatie/media-library.php', 'media-library'
        );
    }

    protected function configureProviders(): void
    {
        $this->app->register(MediaLibraryServiceProvider::class);
    }
}
