<?php

declare(strict_types=1);

namespace Venture\Aeon\Facades;

use BackedEnum;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Venture\Aeon\Services\AccessManager;

/**
 * Access Facade for AccessManager
 *
 * Provides a static interface for managing roles and permissions
 * across the application modules.
 *
 * @method static Collection permissions()
 * @method static Collection roles()
 * @method static Collection administratorRoles()
 * @method static void addPermissions(Collection $permissions)
 * @method static void addRoles(Collection $roles)
 * @method static void addAdministratorRole(BackedEnum $role)
 *
 * @see AccessManager
 */
class Access extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return AccessManager::class;
    }
}
