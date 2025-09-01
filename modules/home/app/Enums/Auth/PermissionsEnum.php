<?php

namespace Venture\Home\Enums\Auth;

use Illuminate\Support\Collection;
use Venture\Home\Enums\Auth\Permissions\AccountPermissionsEnum;
use Venture\Home\Enums\Auth\Permissions\AttachmentPermissionsEnum;
use Venture\Home\Enums\Auth\Permissions\MembershipPermissionsEnum;
use Venture\Home\Enums\Auth\Permissions\PagePermissionsEnum;
use Venture\Home\Enums\Auth\Permissions\TeamPermissionsEnum;

enum PermissionsEnum
{
    public static function all(): Collection
    {
        return Collection::make([
            PagePermissionsEnum::all(),
            AttachmentPermissionsEnum::all(),
            AccountPermissionsEnum::all(),
            TeamPermissionsEnum::all(),
            MembershipPermissionsEnum::all(),
        ])->flatten(1)->map->value;
    }
}
