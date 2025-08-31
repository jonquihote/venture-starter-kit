<?php

namespace Venture\Aeon\Packages\FirstParty\Reverb\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Laravel\Reverb\ApplicationManagerServiceProvider;
use Laravel\Reverb\ReverbServiceProvider as BaseReverbServiceProvider;

class ReverbServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->configurePackage();
        $this->configureProviders();
    }

    public function boot(): void {}

    protected function configurePackage(): void
    {
        $configPath = File::exists(config_path('reverb.php'))
            ? config_path('reverb.php')
            : __DIR__ . '/../../../../../config/laravel/reverb.php';

        $this->mergeConfigFrom($configPath, 'reverb');
    }

    protected function configureProviders(): void
    {
        $this->app->register(ApplicationManagerServiceProvider::class);
        $this->app->register(BaseReverbServiceProvider::class);
    }
}
