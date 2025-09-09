<?php

namespace Venture\Aeon\Tests\Stubs;

use Venture\Aeon\Concerns\Auth\InteractsWithPermissions;

enum AccountPermissionsEnum: string
{
    use InteractsWithPermissions;

    case ViewAny = 'account.view-any';
    case View = 'account.view';
    case Create = 'account.create';
    case Update = 'account.update';
    case Delete = 'account.delete';
}
