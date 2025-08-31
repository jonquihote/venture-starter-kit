<?php

namespace Venture\Home\Enums\Auth\Permissions;

use Venture\Aeon\Concerns\Auth\InteractsWithPermissions;

enum TeamPermissionsEnum: string
{
    use InteractsWithPermissions;

    case ViewAny = 'home::authorization/models/team.view-any';
    case Create = 'home::authorization/models/team.create';
    case Update = 'home::authorization/models/team.update';
    case View = 'home::authorization/models/team.view';
    case Delete = 'home::authorization/models/team.delete';
    case Restore = 'home::authorization/models/team.restore';
    case ForceDelete = 'home::authorization/models/team.force-delete';
    case Reorder = 'home::authorization/models/team.reorder';
    case DeleteAny = 'home::authorization/models/team.delete-any';
    case RestoreAny = 'home::authorization/models/team.restore-any';
    case ForceDeleteAny = 'home::authorization/models/team.force-delete-any';
}
