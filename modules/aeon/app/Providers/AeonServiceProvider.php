<?php

namespace Venture\Aeon\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Traits\PathNamespace;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Venture\Aeon\Console\Commands\InitializeAccessCommand;
use Venture\Aeon\Console\Commands\ResetApplicationCommand;
use Venture\Aeon\Packages\Filament\Filament\Providers\FilamentDataProcessingServiceProvider;
use Venture\Aeon\Packages\FirstParty\Horizon\Providers\HorizonServiceProvider;
use Venture\Aeon\Packages\FirstParty\Pulse\Providers\PulseServiceProvider;
use Venture\Aeon\Packages\FirstParty\Reverb\Providers\ReverbServiceProvider;
use Venture\Aeon\Packages\FirstParty\Scout\Providers\ScoutServiceProvider;
use Venture\Aeon\Packages\FirstParty\Telescope\Providers\TelescopeServiceProvider;
use Venture\Aeon\Packages\Spatie\Activitylog\Providers\ActivityLogServiceProvider;
use Venture\Aeon\Packages\Spatie\Markdown\Providers\MarkdownServiceProvider;
use Venture\Aeon\Packages\Spatie\MediaLibrary\Providers\MediaLibraryServiceProvider;
use Venture\Aeon\Packages\Spatie\Permission\Providers\PermissionServiceProvider;
use Venture\Aeon\Packages\Spatie\Settings\Providers\SettingsServiceProvider;
use Venture\Aeon\Packages\Spatie\Tags\Providers\TagsServiceProvider;

/**
 * @codeCoverageIgnore
 */
class AeonServiceProvider extends ServiceProvider
{
    use PathNamespace;

    protected string $name = 'Aeon';

    protected string $nameLower = 'aeon';

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
        $this->loadMigrationsFrom(module_path($this->name, 'database/migrations'));
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(AccessSingletonServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);

        $this->app->register(HorizonServiceProvider::class);
        $this->app->register(PulseServiceProvider::class);
        $this->app->register(ReverbServiceProvider::class);
        $this->app->register(ScoutServiceProvider::class);
        $this->app->register(TelescopeServiceProvider::class);

        $this->app->register(ActivityLogServiceProvider::class);
        $this->app->register(MarkdownServiceProvider::class);
        $this->app->register(MediaLibraryServiceProvider::class);
        $this->app->register(PermissionServiceProvider::class);
        $this->app->register(SettingsServiceProvider::class);
        $this->app->register(TagsServiceProvider::class);

        $this->app->register(FilamentDataProcessingServiceProvider::class);
    }

    /**
     * Register commands in the format of Command::class
     */
    protected function registerCommands(): void
    {
        $this->commands([
            ResetApplicationCommand::class,
            InitializeAccessCommand::class,
        ]);
    }

    /**
     * Register command Schedules.
     */
    protected function registerCommandSchedules(): void
    {
        $this->app->booted(function (): void {
            $schedule = $this->app->make(Schedule::class);

            $schedule->command('inspire')->everyMinute();
            $schedule->command('telescope:prune --hours=168')->daily();
        });
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/' . $this->nameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->nameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->name, 'lang'), $this->nameLower);
            $this->loadJsonTranslationsFrom(module_path($this->name, 'lang'));
        }
    }

    /**
     * Register config.
     */
    protected function registerConfig(): void
    {
        $configPath = module_path($this->name, config('modules.paths.generator.config.path'));

        if (is_dir($configPath)) {
            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($configPath));

            foreach ($iterator as $file) {
                if ($file->isFile() && $file->getExtension() === 'php') {
                    $config = str_replace($configPath . DIRECTORY_SEPARATOR, '', $file->getPathname());
                    $config_key = str_replace([DIRECTORY_SEPARATOR, '.php'], ['.', ''], $config);
                    $segments = explode('.', $this->nameLower . '.' . $config_key);

                    // Remove duplicated adjacent segments
                    $normalized = [];
                    foreach ($segments as $segment) {
                        if (end($normalized) !== $segment) {
                            $normalized[] = $segment;
                        }
                    }

                    $key = ($config === 'config.php') ? $this->nameLower : implode('.', $normalized);

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
        $viewPath = resource_path('views/modules/' . $this->nameLower);
        $sourcePath = module_path($this->name, 'resources/views');

        $this->publishes([$sourcePath => $viewPath], ['views', $this->nameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->nameLower);

        Blade::componentNamespace(config('modules.namespace') . '\\' . $this->name . '\\View\\Components', $this->nameLower);
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
            if (is_dir($path . '/modules/' . $this->nameLower)) {
                $paths[] = $path . '/modules/' . $this->nameLower;
            }
        }

        return $paths;
    }
}
