<?php

namespace Venture\Alpha\Enums\Auth\Permissions;

use Venture\Aeon\Concerns\Auth\InteractsWithPermissions;

enum MembershipPermissionsEnum: string
{
    use InteractsWithPermissions;

    case ViewAny = 'alpha::authorization/models/membership.view-any';
    case Create = 'alpha::authorization/models/membership.create';
    case Update = 'alpha::authorization/models/membership.update';
    case View = 'alpha::authorization/models/membership.view';
    case Delete = 'alpha::authorization/models/membership.delete';
    case Restore = 'alpha::authorization/models/membership.restore';
    case ForceDelete = 'alpha::authorization/models/membership.force-delete';
    case Reorder = 'alpha::authorization/models/membership.reorder';
    case DeleteAny = 'alpha::authorization/models/membership.delete-any';
    case RestoreAny = 'alpha::authorization/models/membership.restore-any';
    case ForceDeleteAny = 'alpha::authorization/models/membership.force-delete-any';
}
