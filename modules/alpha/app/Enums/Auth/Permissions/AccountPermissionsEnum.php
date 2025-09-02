<?php

namespace Venture\Alpha\Enums\Auth\Permissions;

use Venture\Aeon\Concerns\Auth\InteractsWithPermissions;

enum AccountPermissionsEnum: string
{
    use InteractsWithPermissions;

    case ViewAny = 'alpha::authorization/models/account.view-any';
    case Create = 'alpha::authorization/models/account.create';
    case Update = 'alpha::authorization/models/account.update';
    case View = 'alpha::authorization/models/account.view';
    case Delete = 'alpha::authorization/models/account.delete';
    case Restore = 'alpha::authorization/models/account.restore';
    case ForceDelete = 'alpha::authorization/models/account.force-delete';
    case Reorder = 'alpha::authorization/models/account.reorder';
    case DeleteAny = 'alpha::authorization/models/account.delete-any';
    case RestoreAny = 'alpha::authorization/models/account.restore-any';
    case ForceDeleteAny = 'alpha::authorization/models/account.force-delete-any';

    case CustomExport = 'alpha::authorization/models/account.custom-export';
    case CustomImport = 'alpha::authorization/models/account.custom-import';
    case CustomEditRoles = 'alpha::authorization/models/account.custom-edit-roles';
    case CustomEditPassword = 'alpha::authorization/models/account.custom-edit-password';
}
