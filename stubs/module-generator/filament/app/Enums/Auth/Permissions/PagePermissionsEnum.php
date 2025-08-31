<?php

namespace Venture\{Module}\Enums\Auth\Permissions;

use Venture\Aeon\Concerns\Auth\InteractsWithPermissions;

enum PagePermissionsEnum: string
{
    use InteractsWithPermissions;

    case Dashboard = '{module}::authorization/pages.dashboard';
}
