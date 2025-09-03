<?php

namespace Venture\Alpha\Enums\Auth\Permissions;

use Venture\Aeon\Concerns\Auth\InteractsWithPermissions;

enum InvitationPermissionsEnum: string
{
    use InteractsWithPermissions;

    case ViewAny = 'omega::authorization/models/invitation.view-any';
    case Create = 'omega::authorization/models/invitation.create';
    case Update = 'omega::authorization/models/invitation.update';
    case View = 'omega::authorization/models/invitation.view';
    case Delete = 'omega::authorization/models/invitation.delete';
    case Restore = 'omega::authorization/models/invitation.restore';
    case ForceDelete = 'omega::authorization/models/invitation.force-delete';
    case Reorder = 'omega::authorization/models/invitation.reorder';
    case DeleteAny = 'omega::authorization/models/invitation.delete-any';
    case RestoreAny = 'omega::authorization/models/invitation.restore-any';
    case ForceDeleteAny = 'omega::authorization/models/invitation.force-delete-any';
}
