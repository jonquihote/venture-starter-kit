<?php

namespace Venture\Blueprint\Enums\Auth\Permissions;

use Venture\Aeon\Concerns\Auth\InteractsWithPermissions;

enum PagePermissionsEnum: string
{
    use InteractsWithPermissions;

    case Dashboard = 'blueprint::authorization/pages.dashboard';
}
