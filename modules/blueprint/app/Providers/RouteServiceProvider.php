<?php

namespace Venture\Blueprint\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Venture\Blueprint\Concerns\InteractsWithModule;

class RouteServiceProvider extends ServiceProvider
{
    use InteractsWithModule;

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes(): void
    {
        $slug = $this->getModuleSlug();

        Route::group([
            'middleware' => ['web'],
            'prefix' => "/{$slug}",
            'as' => "@{$slug}.",
        ], function (): void {
            $this->loadRoutesFrom(module_path($this->getModuleName(), '/routes/web.php'));
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes(): void
    {
        $slug = $this->getModuleSlug();

        Route::group([
            'middleware' => ['api'],
            'prefix' => "/{$slug}/v1",
            'as' => "@{$slug}.v1.",
        ], function (): void {
            $this->loadRoutesFrom(module_path($this->getModuleName(), '/routes/api-v1.php'));
        });
    }
}
