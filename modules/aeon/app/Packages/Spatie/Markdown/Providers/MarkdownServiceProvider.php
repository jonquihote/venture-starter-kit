<?php

namespace Venture\Aeon\Packages\Spatie\Markdown\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Spatie\LaravelMarkdown\MarkdownServiceProvider as BaseMarkdownServiceProvider;

class MarkdownServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->configurePackage();
        $this->configureProviders();
    }

    public function boot(): void {}

    protected function configurePackage(): void
    {
        $configPath = File::exists(config_path('markdown.php'))
            ? config_path('markdown.php')
            : __DIR__ . '/../../../../../config/spatie/markdown.php';

        $this->mergeConfigFrom($configPath, 'markdown');
    }

    protected function configureProviders(): void
    {
        $this->app->register(BaseMarkdownServiceProvider::class);
    }
}
