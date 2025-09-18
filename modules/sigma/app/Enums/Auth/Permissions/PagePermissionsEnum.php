<?php

namespace Venture\Sigma\Enums\Auth\Permissions;

use Venture\Aeon\Concerns\Auth\InteractsWithPermissions;

enum PagePermissionsEnum: string
{
    use InteractsWithPermissions;

    case Dashboard = 'sigma::authorization/pages.dashboard';
}
