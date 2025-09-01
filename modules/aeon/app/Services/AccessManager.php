<?php

declare(strict_types=1);

namespace Venture\Aeon\Services;

use BackedEnum;
use Illuminate\Support\Collection;

/**
 * AccessManager serves as a centralized registry for roles and permissions
 * across modules. It provides a simple API for modules to register their authorization
 * components into the system.
 */
class AccessManager
{
    protected Collection $permissions;

    protected Collection $roles;

    protected Collection $administratorRoles;

    public function __construct()
    {
        $this->permissions = new Collection;
        $this->roles = new Collection;
        $this->administratorRoles = new Collection;
    }

    /**
     * Get all registered permissions.
     */
    public function permissions(): Collection
    {
        return $this->permissions;
    }

    /**
     * Get all registered roles.
     */
    public function roles(): Collection
    {
        return $this->roles;
    }

    /**
     * Get all administrator roles.
     */
    public function administratorRoles(): Collection
    {
        return $this->administratorRoles;
    }

    /**
     * Add multiple permissions to the registry.
     */
    public function addPermissions(Collection $permissions): void
    {
        $this->permissions = $this->permissions->merge($permissions);
    }

    /**
     * Add multiple roles to the registry.
     */
    public function addRoles(Collection $roles): void
    {
        $this->roles = $this->roles->merge($roles);
    }

    /**
     * Add a single administrator role to the registry.
     */
    public function addAdministratorRole(BackedEnum $role): void
    {
        $this->administratorRoles->push($role);
    }
}
