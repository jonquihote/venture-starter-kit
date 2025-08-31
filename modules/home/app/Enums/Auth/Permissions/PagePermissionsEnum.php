<?php

namespace Venture\Home\Enums\Auth\Permissions;

use Venture\Aeon\Concerns\Auth\InteractsWithPermissions;

enum PagePermissionsEnum: string
{
    use InteractsWithPermissions;

    case Dashboard = 'home::authorization/pages.dashboard';

    case ManageTenancySettings = 'home::authorization/pages.manage-tenancy-settings';
}
