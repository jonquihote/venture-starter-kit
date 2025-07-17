<?php

namespace Venture\Home\Enums\Auth;

use Illuminate\Support\Collection;
use Venture\Home\Enums\Auth\Permissions\PagePermissionsEnum;
use Venture\Home\Enums\Auth\Permissions\TemporaryFileResourcePermissionsEnum;
use Venture\Home\Enums\Auth\Permissions\UserResourcePermissionsEnum;

enum PermissionsEnum
{
    public static function all(): Collection
    {
        return Collection::make([
            PagePermissionsEnum::all(),

            UserResourcePermissionsEnum::all(),
            TemporaryFileResourcePermissionsEnum::all(),
        ])
            ->flatten(1)
            ->map
            ->value;
    }
}
