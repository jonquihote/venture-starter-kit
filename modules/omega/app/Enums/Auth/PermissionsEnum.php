<?php

namespace Venture\Omega\Enums\Auth;

use Illuminate\Support\Collection;
use Venture\Omega\Enums\Auth\Permissions\PagePermissionsEnum;

enum PermissionsEnum
{
    public static function all(): Collection
    {
        return Collection::make([
            PagePermissionsEnum::all(),
        ])->flatten(1)->map->value;
    }
}
