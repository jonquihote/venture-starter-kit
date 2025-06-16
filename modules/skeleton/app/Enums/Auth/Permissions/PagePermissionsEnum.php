<?php

namespace Venture\Skeleton\Enums\Auth\Permissions;

use Venture\Aeon\Concerns\InteractsWithPermissionsEnum;

enum PagePermissionsEnum: string
{
    use InteractsWithPermissionsEnum;

    case DASHBOARD = 'skeleton::authorization/permissions/pages.dashboard';
}
