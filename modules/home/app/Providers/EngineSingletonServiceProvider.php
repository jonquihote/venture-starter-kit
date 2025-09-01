<?php

declare(strict_types=1);

namespace Venture\Home\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Venture\Home\Services\EngineManager;

/**
 * EngineSingletonServiceProvider
 *
 * Dedicated service provider for registering engine-related services.
 * This provider is deferred to improve application performance.
 */
class EngineSingletonServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(function (): EngineManager {
            return new EngineManager;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return [
            EngineManager::class,
        ];
    }
}
