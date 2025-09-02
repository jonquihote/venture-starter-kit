<?php

namespace Venture\Home\Enums\Auth\Permissions;

use Venture\Aeon\Concerns\Auth\InteractsWithPermissions;

enum SubscriptionPermissionsEnum: string
{
    use InteractsWithPermissions;

    case ViewAny = 'home::authorization/models/subscription.view-any';
    case Create = 'home::authorization/models/subscription.create';
    case Update = 'home::authorization/models/subscription.update';
    case View = 'home::authorization/models/subscription.view';
    case Delete = 'home::authorization/models/subscription.delete';
    case Restore = 'home::authorization/models/subscription.restore';
    case ForceDelete = 'home::authorization/models/subscription.force-delete';
    case Reorder = 'home::authorization/models/subscription.reorder';
    case DeleteAny = 'home::authorization/models/subscription.delete-any';
    case RestoreAny = 'home::authorization/models/subscription.restore-any';
    case ForceDeleteAny = 'home::authorization/models/subscription.force-delete-any';
}
