<?php

namespace Venture\Alpha\Enums\Auth;

use Illuminate\Support\Collection;
use Venture\Alpha\Enums\Auth\Permissions\AccountPermissionsEnum;
use Venture\Alpha\Enums\Auth\Permissions\ApplicationPermissionsEnum;
use Venture\Alpha\Enums\Auth\Permissions\AttachmentPermissionsEnum;
use Venture\Alpha\Enums\Auth\Permissions\MembershipPermissionsEnum;
use Venture\Alpha\Enums\Auth\Permissions\PagePermissionsEnum;
use Venture\Alpha\Enums\Auth\Permissions\SubscriptionPermissionsEnum;
use Venture\Alpha\Enums\Auth\Permissions\TeamPermissionsEnum;

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
            ApplicationPermissionsEnum::all(),
            SubscriptionPermissionsEnum::all(),
        ])->flatten(1)->map->value;
    }
}
