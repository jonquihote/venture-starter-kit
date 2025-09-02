<?php

namespace Venture\Alpha\Enums\Auth\Permissions;

use Venture\Aeon\Concerns\Auth\InteractsWithPermissions;

enum ApplicationPermissionsEnum: string
{
    use InteractsWithPermissions;

    case ViewAny = 'alpha::authorization/models/application.view-any';
    case Create = 'alpha::authorization/models/application.create';
    case Update = 'alpha::authorization/models/application.update';
    case View = 'alpha::authorization/models/application.view';
    case Delete = 'alpha::authorization/models/application.delete';
    case Restore = 'alpha::authorization/models/application.restore';
    case ForceDelete = 'alpha::authorization/models/application.force-delete';
    case Reorder = 'alpha::authorization/models/application.reorder';
    case DeleteAny = 'alpha::authorization/models/application.delete-any';
    case RestoreAny = 'alpha::authorization/models/application.restore-any';
    case ForceDeleteAny = 'alpha::authorization/models/application.force-delete-any';
}
