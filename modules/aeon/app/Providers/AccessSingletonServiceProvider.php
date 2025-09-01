<?php

declare(strict_types=1);

namespace Venture\Aeon\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Venture\Aeon\Services\AccessManager;

/**
 * AccessSingletonServiceProvider
 *
 * Dedicated service provider for registering authorization-related services.
 * This provider is deferred to improve application performance.
 */
class AccessSingletonServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(function (): AccessManager {
            return new AccessManager;
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
            AccessManager::class,
        ];
    }
}
