<?php

namespace Venture\Aeon\Auth;

use BackedEnum;
use Illuminate\Support\Collection;

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

    public function permissions(): Collection
    {
        return $this->permissions;
    }

    public function roles(): Collection
    {
        return $this->roles;
    }

    public function administratorRoles(): Collection
    {
        return $this->administratorRoles;
    }

    public function addPermissions(Collection $permissions): void
    {
        $this->permissions = $this->permissions->merge($permissions);
    }

    public function addRoles(Collection $roles): void
    {
        $this->roles = $this->roles->merge($roles);
    }

    public function addAdministratorRole(BackedEnum $role): void
    {
        $this->administratorRoles->push($role->value);
    }
}
