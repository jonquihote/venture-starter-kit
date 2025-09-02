<?php

declare(strict_types=1);

namespace Venture\Alpha\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Venture\Alpha\Data\ApplicationData;
use Venture\Alpha\Services\EngineManager;

/**
 * Engine Facade for EngineManager
 *
 * Provides a static interface for managing applications
 * across the application modules.
 *
 * @method static Collection applications()
 * @method static void addApplication(ApplicationData $applicationData)
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
