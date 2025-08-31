<?php

namespace Venture\Aeon\Packages\Spatie\Permission\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\PermissionServiceProvider as BasePermissionServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->configurePackage();
        $this->configureProviders();
    }

    public function boot(): void {}

    protected function configurePackage(): void
    {
        $configPath = File::exists(config_path('permission.php'))
            ? config_path('permission.php')
            : __DIR__ . '/../../../../../config/spatie/permission.php';

        $this->mergeConfigFrom($configPath, 'permission');
    }

    protected function configureProviders(): void
    {
        $this->app->register(BasePermissionServiceProvider::class);
    }
}
