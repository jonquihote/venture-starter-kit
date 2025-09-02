<?php

namespace Venture\Alpha\Enums\Auth\Permissions;

use Venture\Aeon\Concerns\Auth\InteractsWithPermissions;

enum TeamPermissionsEnum: string
{
    use InteractsWithPermissions;

    case ViewAny = 'alpha::authorization/models/team.view-any';
    case Create = 'alpha::authorization/models/team.create';
    case Update = 'alpha::authorization/models/team.update';
    case View = 'alpha::authorization/models/team.view';
    case Delete = 'alpha::authorization/models/team.delete';
    case Restore = 'alpha::authorization/models/team.restore';
    case ForceDelete = 'alpha::authorization/models/team.force-delete';
    case Reorder = 'alpha::authorization/models/team.reorder';
    case DeleteAny = 'alpha::authorization/models/team.delete-any';
    case RestoreAny = 'alpha::authorization/models/team.restore-any';
    case ForceDeleteAny = 'alpha::authorization/models/team.force-delete-any';
}
