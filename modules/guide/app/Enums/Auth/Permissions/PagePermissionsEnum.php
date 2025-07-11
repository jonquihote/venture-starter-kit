<?php

namespace Venture\Guide\Enums\Auth\Permissions;

use Venture\Aeon\Auth\Concerns\InteractsWithPermissionsEnum;

enum PagePermissionsEnum: string
{
    use InteractsWithPermissionsEnum;

    case DASHBOARD = 'guide::authorization/permissions/pages.dashboard';
}
