<?php

namespace Venture\Alpha\Enums\Auth\Permissions;

use Venture\Aeon\Concerns\Auth\InteractsWithPermissions;

enum SubscriptionPermissionsEnum: string
{
    use InteractsWithPermissions;

    case ViewAny = 'alpha::authorization/models/subscription.view-any';
    case Create = 'alpha::authorization/models/subscription.create';
    case Update = 'alpha::authorization/models/subscription.update';
    case View = 'alpha::authorization/models/subscription.view';
    case Delete = 'alpha::authorization/models/subscription.delete';
    case Restore = 'alpha::authorization/models/subscription.restore';
    case ForceDelete = 'alpha::authorization/models/subscription.force-delete';
    case Reorder = 'alpha::authorization/models/subscription.reorder';
    case DeleteAny = 'alpha::authorization/models/subscription.delete-any';
    case RestoreAny = 'alpha::authorization/models/subscription.restore-any';
    case ForceDeleteAny = 'alpha::authorization/models/subscription.force-delete-any';
}
