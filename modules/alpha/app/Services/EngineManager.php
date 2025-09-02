<?php

declare(strict_types=1);

namespace Venture\Alpha\Services;

use Illuminate\Support\Collection;
use Venture\Alpha\Data\ApplicationData;

/**
 * EngineManager serves as a centralized registry for applications
 * across modules. It provides a simple API for modules to register their
 * application components into the system.
 */
class EngineManager
{
    protected Collection $applications;

    public function __construct()
    {
        $this->applications = new Collection;
    }

    /**
     * Get all registered applications.
     */
    public function applications(): Collection
    {
        return $this->applications;
    }

    /**
     * Add a single application to the registry.
     */
    public function addApplication(ApplicationData $applicationData): void
    {
        $this->applications->push($applicationData);
    }
}
