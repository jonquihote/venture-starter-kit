<?php

declare(strict_types=1);

namespace Venture\Aeon\Facades;

use BackedEnum;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Laravel\Reverb\Application;
use Venture\Aeon\Data\ApplicationData;
use Venture\Aeon\Services\AuthorizationManager;

/**
 * Access Facade for AuthorizationManager
 *
 * Provides a static interface for managing roles and permissions
 * across the application modules.
 *
 * @method static Collection permissions()
 * @method static Collection roles()
 * @method static Collection administratorRoles()
 * @method static Collection applications()
 * @method static void addPermissions(Collection $permissions)
 * @method static void addRoles(Collection $roles)
 * @method static void addAdministratorRole(BackedEnum $role)
 * @method static void addApplication(ApplicationData $application)
 *
 * @see AuthorizationManager
 */
class Access extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return AuthorizationManager::class;
    }
}
