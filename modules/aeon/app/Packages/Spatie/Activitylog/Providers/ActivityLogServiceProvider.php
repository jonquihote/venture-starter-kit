<?php

namespace Venture\Aeon\Packages\Spatie\Activitylog\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\ActivitylogServiceProvider as BaseActivityLogServiceProvider;

class ActivityLogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->configurePackage();
        $this->configureProviders();
    }

    public function boot(): void {}

    protected function configurePackage(): void
    {
        $configPath = File::exists(config_path('activitylog.php'))
            ? config_path('activitylog.php')
            : __DIR__ . '/../../../../../config/spatie/activitylog.php';

        $this->mergeConfigFrom($configPath, 'activitylog');
    }

    protected function configureProviders(): void
    {
        $this->app->register(BaseActivityLogServiceProvider::class);
    }
}
