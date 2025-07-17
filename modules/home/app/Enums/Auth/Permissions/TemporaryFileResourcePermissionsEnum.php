<?php

namespace Venture\Home\Enums\Auth\Permissions;

use Venture\Aeon\Auth\Concerns\InteractsWithPermissionsEnum;

enum TemporaryFileResourcePermissionsEnum: string
{
    use InteractsWithPermissionsEnum;

    case VIEW_ANY = 'home::authorization/permissions/resources/temporary-file.view-any';
    case CREATE = 'home::authorization/permissions/resources/temporary-file.create';
    case UPDATE = 'home::authorization/permissions/resources/temporary-file.update';
    case VIEW = 'home::authorization/permissions/resources/temporary-file.view';
    case DELETE = 'home::authorization/permissions/resources/temporary-file.delete';
    case DELETE_ANY = 'home::authorization/permissions/resources/temporary-file.delete-any';
    case FORCE_DELETE = 'home::authorization/permissions/resources/temporary-file.force-delete';
    case FORCE_DELETE_ANY = 'home::authorization/permissions/resources/temporary-file.force-delete-any';
    case RESTORE = 'home::authorization/permissions/resources/temporary-file.restore';
    case REORDER = 'home::authorization/permissions/resources/temporary-file.reorder';
}
