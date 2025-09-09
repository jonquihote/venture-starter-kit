<?php

namespace Venture\Aeon\Tests\Stubs;

use Venture\Aeon\Concerns\Auth\InteractsWithPermissions;

enum PagePermissionsEnum: string
{
    use InteractsWithPermissions;

    case Dashboard = 'dashboard';
    case HorizonDashboard = 'horizon-dashboard';
    case PulseDashboard = 'pulse-dashboard';
    case TelescopeDashboard = 'telescope-dashboard';
}
