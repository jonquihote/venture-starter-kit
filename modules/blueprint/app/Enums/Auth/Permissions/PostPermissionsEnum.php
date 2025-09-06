<?php

namespace Venture\Blueprint\Enums\Auth\Permissions;

use Venture\Aeon\Concerns\Auth\InteractsWithPermissions;

enum PostPermissionsEnum: string
{
    use InteractsWithPermissions;

    case ViewAny = 'blueprint::authorization/models/post.view-any';
    case Create = 'blueprint::authorization/models/post.create';
    case Update = 'blueprint::authorization/models/post.update';
    case View = 'blueprint::authorization/models/post.view';
    case Delete = 'blueprint::authorization/models/post.delete';
    case Restore = 'blueprint::authorization/models/post.restore';
    case ForceDelete = 'blueprint::authorization/models/post.force-delete';
    case Reorder = 'blueprint::authorization/models/post.reorder';
    case DeleteAny = 'blueprint::authorization/models/post.delete-any';
    case RestoreAny = 'blueprint::authorization/models/post.restore-any';
    case ForceDeleteAny = 'blueprint::authorization/models/post.force-delete-any';
}
