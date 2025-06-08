<?php

namespace Venture\Home\Enums\Auth\Permissions;

use Venture\Aeon\Concerns\InteractsWithPermissionsEnum;

enum PagePermissionsEnum: string
{
    use InteractsWithPermissionsEnum;

    case DASHBOARD = 'home::authorization.permissions.pages.dashboard';
}
