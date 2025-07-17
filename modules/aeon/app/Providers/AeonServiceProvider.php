<?php

namespace Venture\Aeon\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Traits\PathNamespace;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Venture\Aeon\Console\Commands\BootstrapCommand;
use Venture\Aeon\Console\Commands\ResetCommand;
use Venture\Aeon\Console\Commands\SyncIconsCommand;
use Venture\Aeon\Enums\ModulesEnum;
use Venture\Aeon\Providers\Laravel\Horizon\PackageServiceProvider as HorizonPackageServiceProvider;
use Venture\Aeon\Providers\Laravel\Pulse\PackageServiceProvider as PulsePackageServiceProvider;
use Venture\Aeon\Providers\Laravel\Telescope\PackageServiceProvider as TelescopePackageServiceProvider;
use Venture\Aeon\Providers\Spatie\LaravelSettings\PackageServiceProvider as LaravelSettingsPackageServiceProvider;
use Venture\Aeon\Providers\Spatie\MediaLibrary\PackageServiceProvider as MediaLibraryPackageServiceProvider;
use Venture\Aeon\Providers\Spatie\Tags\PackageServiceProvider as TagsPackageServiceProvider;

class AeonServiceProvider extends ServiceProvider
{
    use PathNamespace;

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->registerCommands();
        $this->registerCommandSchedules();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path(ModulesEnum::AEON->name(), 'database/migrations'));
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);

        $this->app->register(HorizonPackageServiceProvider::class);
        $this->app->register(PulsePackageServiceProvider::class);
        $this->app->register(TelescopePackageServiceProvider::class);

        $this->app->register(MediaLibraryPackageServiceProvider::class);
        $this->app->register(TagsPackageServiceProvider::class);
        $this->app->register(LaravelSettingsPackageServiceProvider::class);
    }

    /**
     * Register commands in the format of Command::class
     */
    protected function registerCommands(): void
    {
        $this->commands([
            ResetCommand::class,
            BootstrapCommand::class,
            SyncIconsCommand::class,
        ]);
    }

    /**
     * Register command Schedules.
     */
    protected function registerCommandSchedules(): void
    {
        $this->app->booted(function (): void {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('telescope:prune --hours=48')->daily();
        });
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/' . ModulesEnum::AEON->slug());

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, ModulesEnum::AEON->slug());
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path(ModulesEnum::AEON->name(), 'lang'), ModulesEnum::AEON->slug());
            $this->loadJsonTranslationsFrom(module_path(ModulesEnum::AEON->name(), 'lang'));
        }
    }

    /**
     * Register config.
     */
    protected function registerConfig(): void
    {
        $configPath = module_path(ModulesEnum::AEON->name(), config('modules.paths.generator.config.path'));

        if (is_dir($configPath)) {
            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($configPath));

            foreach ($iterator as $file) {
                if ($file->isFile() && $file->getExtension() === 'php') {
                    $config = str_replace($configPath . DIRECTORY_SEPARATOR, '', $file->getPathname());
                    $config_key = str_replace([DIRECTORY_SEPARATOR, '.php'], ['.', ''], $config);
                    $segments = explode('.', ModulesEnum::AEON->slug() . '.' . $config_key);

                    // Remove duplicated adjacent segments
                    $normalized = [];
                    foreach ($segments as $segment) {
                        if (end($normalized) !== $segment) {
                            $normalized[] = $segment;
                        }
                    }

                    $key = ($config === 'config.php') ? ModulesEnum::AEON->slug() : implode('.', $normalized);

                    $this->publishes([$file->getPathname() => config_path($config)], 'config');
                    $this->merge_config_from($file->getPathname(), $key);
                }
            }
        }
    }

    /**
     * Merge config from the given path recursively.
     */
    protected function merge_config_from(string $path, string $key): void
    {
        $existing = config($key, []);
        $module_config = require $path;

        config([$key => array_replace_recursive($existing, $module_config)]);
    }

    /**
     * Register views.
     */
    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/' . ModulesEnum::AEON->slug());
        $sourcePath = module_path(ModulesEnum::AEON->name(), 'resources/views');

        $this->publishes([$sourcePath => $viewPath], ['views', ModulesEnum::AEON->slug() . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), ModulesEnum::AEON->slug());

        Blade::componentNamespace(config('modules.namespace') . '\\' . ModulesEnum::AEON->name() . '\\View\\Components', ModulesEnum::AEON->slug());
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (config('view.paths') as $path) {
            if (is_dir($path . '/modules/' . ModulesEnum::AEON->slug())) {
                $paths[] = $path . '/modules/' . ModulesEnum::AEON->slug();
            }
        }

        return $paths;
    }
}
