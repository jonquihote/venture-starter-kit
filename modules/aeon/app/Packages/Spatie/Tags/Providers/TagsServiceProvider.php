<?php

namespace Venture\Aeon\Packages\Spatie\Tags\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Spatie\Tags\TagsServiceProvider as BaseTagsServiceProvider;

/**
 * @codeCoverageIgnore
 *
 * This file exists to accommodate `spatie_` prefixed database table & to customize configuration for Tags
 */
class TagsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->configurePackage();
        $this->configureProviders();
    }

    public function boot(): void {}

    protected function configurePackage(): void
    {
        $configPath = File::exists(config_path('tags.php'))
            ? config_path('tags.php')
            : __DIR__ . '/../../../../../config/spatie/tags.php';

        $this->mergeConfigFrom($configPath, 'tags');
    }

    protected function configureProviders(): void
    {
        $this->app->register(BaseTagsServiceProvider::class);
    }
}
