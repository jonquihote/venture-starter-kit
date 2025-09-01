<?php

declare(strict_types=1);

namespace Venture\Home\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Venture\Home\Services\EngineManager;

/**
 * Engine Facade for EngineManager
 *
 * Provides a static interface for managing applications
 * across the application modules.
 *
 * @method static Collection applications()
 * @method static void addApplication(\Venture\Home\Data\ApplicationData $applicationData)
 *
 * @see EngineManager
 */
class Engine extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return EngineManager::class;
    }
}
