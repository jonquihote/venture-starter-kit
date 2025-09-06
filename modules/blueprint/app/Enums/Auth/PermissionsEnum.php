<?php

namespace Venture\Blueprint\Enums\Auth;

use Illuminate\Support\Collection;
use Venture\Blueprint\Enums\Auth\Permissions\PagePermissionsEnum;
use Venture\Blueprint\Enums\Auth\Permissions\PostPermissionsEnum;

enum PermissionsEnum
{
    public static function all(): Collection
    {
        return Collection::make([
            PagePermissionsEnum::all(),
            PostPermissionsEnum::all(),
        ])->flatten(1)->map->value;
    }
}
