<?php

namespace Venture\Home\Enums\Auth\Permissions;

use Venture\Aeon\Concerns\Auth\InteractsWithPermissions;

enum AttachmentPermissionsEnum: string
{
    use InteractsWithPermissions;

    case ViewAny = 'home::authorization/models/attachment.view-any';
    case Create = 'home::authorization/models/attachment.create';
    case Update = 'home::authorization/models/attachment.update';
    case View = 'home::authorization/models/attachment.view';
    case Delete = 'home::authorization/models/attachment.delete';
    case Restore = 'home::authorization/models/attachment.restore';
    case ForceDelete = 'home::authorization/models/attachment.force-delete';
    case Reorder = 'home::authorization/models/attachment.reorder';
    case DeleteAny = 'home::authorization/models/attachment.delete-any';
    case RestoreAny = 'home::authorization/models/attachment.restore-any';
    case ForceDeleteAny = 'home::authorization/models/attachment.force-delete-any';

    case CustomDownload = 'home::authorization/models/attachment.custom-download';
}
