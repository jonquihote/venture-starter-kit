---
title: 'Access Manager'
slug: aeon-access-manager
is_home_page: 0
documentation_group: Aeon
navigation_group: Development
navigation_sort: 3
created_at: 2025-09-09T09:46:15+00:00
updated_at: 2025-09-09T09:46:15+00:00
---

# Access Manager

**I want to** allow modules/applications/engines to register roles & permissions
**So that** I can quickly assign or remove roles to accounts with their permissions accordingly

**Acceptance Criteria:**

- [ ] Be able to register & retrieve permissions
- [ ] Be able to register & retrieve roles & their permissions
- [ ] Be able to specify which role is the `Administrator` role of that module (one per module)

**Technical Notes:**

- Implement `permissions()` to retrieve all permissions
- Implement `roles()` to retrieve all roles
- Implement `administratorRoles()` to retrieve all administrator roles
- Implement `addPermissions()` to allow module to register permissions
- Implement `addRoles()` to allow module to register roles & permissions
- Implement `addAdministratorRole()` to allow module to register administrator role

**Test Scenarios:**
Using the following example code `PagePermissionsEnum`

```php
enum PagePermissionsEnum: string
{
    use InteractsWithPermissions;

    case Dashboard = 'dashboard';

    case HorizonDashboard = 'horizon-dashboard';
    case PulseDashboard = 'pulse-dashboard';
    case TelescopeDashboard = 'telescope-dashboard';
}
```

Using the following example code `RolesEnum`

```php
enum RolesEnum: string
{
    case Administrator = 'administrator';
    case User = 'user';

    public static function all(): Collection
    {
        return Collection::make(self::cases())
            ->mapWithKeys(function (RolesEnum $role) {
                return [
                    $role->value => $role->permissions(),
                ];
            });
    }

    public function permissions(): Collection
    {
        $permissions = match ($this) {
            self::Administrator => [
                PagePermissionsEnum::all(),
            ],
            self::User => [
                PagePermissionsEnum::only(
                    PagePermissionsEnum::Dashboard,
                ),
            ],
        };

        return Collection::make($permissions)->flatten(1);
    }
}
```

Using the following example code `AccessServiceProvider`

```php
use App\Enums\Auth\PermissionsEnum;
use App\Enums\Auth\RolesEnum;

class AccessServiceProvider extends ServiceProvider
{
    use InteractsWithModule;

    public function register(): void
    {
        Access::addPermissions(PermissionsEnum::all());
        Access::addRoles(RolesEnum::all());
        Access::addAdministratorRole(RolesEnum::Administrator);
    }

    public function boot(): void {}
}

```

I would like to implement an `AccessManager` class with a `Access` facade that allows me to do the following:

1. Add permissions
   Invoking `->addPermissions()` should add permissions (as enum objects) into the list of permissions tracked
   internally through a property called `$permissions` (using `Collection`).

2. Add roles
   Invoking `->addRoles()` should add roles (as enum objects) into the list of permissions tracked internally
   through a property called `$roles` (using `Collection`).

3. Add administrator
   Invoking `->addAdministratorRole()` should add Administrator Role (as enum object) into the list of administrator
   roles tracked internally through a property called `$administratorRoles` (using `Collection`). Each module can
   register exactly one administrator role, and the system supports multiple administrator roles from different modules.

These functions `addRoles` and `addPermissions` should be able to handle multiple calls from different modules that
will merge all these roles, permissions & administrator role together into the internally tracked property. For
`addAdministratorRole` function, it should support idempotent operations (adding the same role multiple times should
not create duplicates) and allow different modules to register their respective administrator roles. 
