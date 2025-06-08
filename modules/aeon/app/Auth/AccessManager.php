<?php

namespace Venture\Aeon\Auth;

use Illuminate\Support\Collection;

class AccessManager
{
    public Collection $permissions;

    public Collection $roles;

    public function __construct()
    {
        $this->permissions = new Collection;
        $this->roles = new Collection;
    }

    public function permissions(): Collection
    {
        return $this->permissions;
    }

    public function roles(): Collection
    {
        return $this->roles;
    }

    public function addPermissions(Collection $permissions): void
    {
        $this->permissions = $this->permissions->merge($permissions);
    }

    public function addRoles(Collection $roles): void
    {
        $this->roles = $this->roles->merge($roles);
    }
}
