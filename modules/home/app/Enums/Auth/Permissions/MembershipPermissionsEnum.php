<?php

namespace Venture\Home\Enums\Auth\Permissions;

use Venture\Aeon\Concerns\Auth\InteractsWithPermissions;

enum MembershipPermissionsEnum: string
{
    use InteractsWithPermissions;

    case ViewAny = 'home::authorization/models/membership.view-any';
    case Create = 'home::authorization/models/membership.create';
    case Update = 'home::authorization/models/membership.update';
    case View = 'home::authorization/models/membership.view';
    case Delete = 'home::authorization/models/membership.delete';
    case Restore = 'home::authorization/models/membership.restore';
    case ForceDelete = 'home::authorization/models/membership.force-delete';
    case Reorder = 'home::authorization/models/membership.reorder';
    case DeleteAny = 'home::authorization/models/membership.delete-any';
    case RestoreAny = 'home::authorization/models/membership.restore-any';
    case ForceDeleteAny = 'home::authorization/models/membership.force-delete-any';
}
