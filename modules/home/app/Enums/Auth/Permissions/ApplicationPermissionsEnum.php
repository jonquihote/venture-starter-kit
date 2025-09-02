<?php

namespace Venture\Home\Enums\Auth\Permissions;

use Venture\Aeon\Concerns\Auth\InteractsWithPermissions;

enum ApplicationPermissionsEnum: string
{
    use InteractsWithPermissions;

    case ViewAny = 'home::authorization/models/application.view-any';
    case Create = 'home::authorization/models/application.create';
    case Update = 'home::authorization/models/application.update';
    case View = 'home::authorization/models/application.view';
    case Delete = 'home::authorization/models/application.delete';
    case Restore = 'home::authorization/models/application.restore';
    case ForceDelete = 'home::authorization/models/application.force-delete';
    case Reorder = 'home::authorization/models/application.reorder';
    case DeleteAny = 'home::authorization/models/application.delete-any';
    case RestoreAny = 'home::authorization/models/application.restore-any';
    case ForceDeleteAny = 'home::authorization/models/application.force-delete-any';
}
