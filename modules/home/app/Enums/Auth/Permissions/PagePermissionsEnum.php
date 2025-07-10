<?php

namespace Venture\Home\Enums\Auth\Permissions;

use Venture\Aeon\Auth\Concerns\InteractsWithPermissionsEnum;

enum PagePermissionsEnum: string
{
    use InteractsWithPermissionsEnum;

    case DASHBOARD = 'home::authorization/permissions/pages.dashboard';
}
