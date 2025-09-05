<?php

namespace Venture\Alpha\Enums\Auth\Permissions;

use Venture\Aeon\Concerns\Auth\InteractsWithPermissions;

enum PagePermissionsEnum: string
{
    use InteractsWithPermissions;

    case Dashboard = 'alpha::authorization/pages.dashboard';

    case ManageTenancySettings = 'alpha::authorization/pages.manage-tenancy-settings';

    case HorizonDashboard = 'alpha::authorization/pages.horizon-dashboard';
    case PulseDashboard = 'alpha::authorization/pages.pulse-dashboard';
    case TelescopeDashboard = 'alpha::authorization/pages.telescope-dashboard';
}
