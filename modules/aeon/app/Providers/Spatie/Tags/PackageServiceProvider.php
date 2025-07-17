<?php

namespace Venture\Aeon\Providers\Spatie\Tags;

use Illuminate\Support\ServiceProvider;
use Spatie\Tags\TagsServiceProvider;

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
            __DIR__ . '/../../../../config/spatie/tags.php', 'tags'
        );
    }

    protected function configureProviders(): void
    {
        $this->app->register(TagsServiceProvider::class);
    }
}
