<?php

namespace Venture\Home\Enums\Auth\Permissions;

use Venture\Aeon\Concerns\Auth\InteractsWithPermissions;

enum AccountPermissionsEnum: string
{
    use InteractsWithPermissions;

    case ViewAny = 'home::authorization/models/account.view-any';
    case Create = 'home::authorization/models/account.create';
    case Update = 'home::authorization/models/account.update';
    case View = 'home::authorization/models/account.view';
    case Delete = 'home::authorization/models/account.delete';
    case Restore = 'home::authorization/models/account.restore';
    case ForceDelete = 'home::authorization/models/account.force-delete';
    case Reorder = 'home::authorization/models/account.reorder';
    case DeleteAny = 'home::authorization/models/account.delete-any';
    case RestoreAny = 'home::authorization/models/account.restore-any';
    case ForceDeleteAny = 'home::authorization/models/account.force-delete-any';

    case CustomExport = 'home::authorization/models/account.custom-export';
    case CustomImport = 'home::authorization/models/account.custom-import';
    case CustomEditRoles = 'home::authorization/models/account.custom-edit-roles';
    case CustomEditPassword = 'home::authorization/models/account.custom-edit-password';
}
