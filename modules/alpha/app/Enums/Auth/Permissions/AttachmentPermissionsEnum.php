<?php

namespace Venture\Alpha\Enums\Auth\Permissions;

use Venture\Aeon\Concerns\Auth\InteractsWithPermissions;

enum AttachmentPermissionsEnum: string
{
    use InteractsWithPermissions;

    case ViewAny = 'alpha::authorization/models/attachment.view-any';
    case Create = 'alpha::authorization/models/attachment.create';
    case Update = 'alpha::authorization/models/attachment.update';
    case View = 'alpha::authorization/models/attachment.view';
    case Delete = 'alpha::authorization/models/attachment.delete';
    case Restore = 'alpha::authorization/models/attachment.restore';
    case ForceDelete = 'alpha::authorization/models/attachment.force-delete';
    case Reorder = 'alpha::authorization/models/attachment.reorder';
    case DeleteAny = 'alpha::authorization/models/attachment.delete-any';
    case RestoreAny = 'alpha::authorization/models/attachment.restore-any';
    case ForceDeleteAny = 'alpha::authorization/models/attachment.force-delete-any';

    case CustomDownload = 'alpha::authorization/models/attachment.custom-download';
}
