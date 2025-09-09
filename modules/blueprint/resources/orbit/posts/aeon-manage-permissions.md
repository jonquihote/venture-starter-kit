---
title: 'Manage Permissions'
slug: aeon-manage-permissions
is_home_page: false
documentation_group: Aeon
navigation_group: Development
navigation_sort: 2.0
created_at: 2025-09-09T04:59:53+00:00
updated_at: 2025-09-09T09:44:27+00:00
---

# Manage Permissions

**I want to** manage the permissions that is available in each module
**So that** I can quickly assign or remove permissions to roles or accounts

**Acceptance Criteria:**

- [ ] Be able to retrieve all permissions
- [ ] Be able to filter certain / specified permissions
- [ ] Be able to reject certain / specified permissions

**Technical Notes:**

- Implement `all()` function that retrieve all permissions
- Implement `only()` function that returns only certain / specified permissions
- Implement `reject()` function that rejects only certain / specified permissions

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

I would like to implement an `InteractsWithPermissions` trait that allows me to do the following:

1. Get all permissions
   Invoking `->all()` should return a `Collection` of enum objects defined in the `Enum`. (i.e the
   `PagePermissionsEnum::Dashboard`, `PagePermissionsEnum::HorizonDashboard`, `PagePermissionsEnum::PulseDashboard` &
   `PagePermissionsEnum::TelescopeDashboard` enum cases)

2. Get only certain / specified permissions
   Invoking `->only(PagePermissionsEnum::Dashboard)` would return a `Collection` that only contains the
   `PagePermissionsEnum::Dashboard` enum object

   Invoking `->only(PagePermissionsEnum::Dashboard, PagePermissionsEnum::PulseDashboard)` would return a `Collection`
   that contains the `PagePermissionsEnum::Dashboard` & `PagePermissionsEnum::PulseDashboard` enum objects

3. Get all permissions except certain / specified permissions
   Invoking `->except(PagePermissionsEnum::Dashboard)` would return a `Collection` that contains the
   `PagePermissionsEnum::HorizonDashboard`, `PagePermissionsEnum::PulseDashboard` &
   `PagePermissionsEnum::TelescopeDashboard` enum objects

   Invoking `->except(PagePermissionsEnum::Dashboard, PagePermissionsEnum::PulseDashboard)` would return a `Collection`
   that contains the `PagePermissionsEnum::HorizonDashboard` & `PagePermissionsEnum::TelescopeDashboard` enum objects
