<?php

namespace Venture\Home\Enums\Auth\Permissions;

use Venture\Aeon\Auth\Concerns\InteractsWithPermissionsEnum;

enum UserResourcePermissionsEnum: string
{
    use InteractsWithPermissionsEnum;

    case VIEW_ANY = 'home::authorization/permissions/resources/user.view-any';
    case CREATE = 'home::authorization/permissions/resources/user.create';
    case UPDATE = 'home::authorization/permissions/resources/user.update';
    case VIEW = 'home::authorization/permissions/resources/user.view';
    case DELETE = 'home::authorization/permissions/resources/user.delete';
    case DELETE_ANY = 'home::authorization/permissions/resources/user.delete-any';
    case FORCE_DELETE = 'home::authorization/permissions/resources/user.force-delete';
    case FORCE_DELETE_ANY = 'home::authorization/permissions/resources/user.force-delete-any';
    case RESTORE = 'home::authorization/permissions/resources/user.restore';
    case REORDER = 'home::authorization/permissions/resources/user.reorder';
}
