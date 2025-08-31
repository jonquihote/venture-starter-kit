<?php

namespace Venture\Aeon\Enum\Auth\Permissions;

use Venture\Aeon\Concerns\Auth\InteractsWithPermissions;

enum PagePermissionsEnum: string
{
    use InteractsWithPermissions;

    case PulseDashboard = 'aeon::authorization/pages.pulse-dashboard';
    case TelescopeDashboard = 'aeon::authorization/pages.telescope-dashboard';
    case HorizonDashboard = 'aeon::authorization/pages.horizon-dashboard';
}
