<?php

namespace Venture\Aeon\Enum\Auth;

use Illuminate\Support\Collection;
use Venture\Aeon\Enum\Auth\Permissions\PagePermissionsEnum;

enum PermissionsEnum
{
    public static function all(): Collection
    {
        return Collection::make([
            PagePermissionsEnum::all(),
        ])->flatten(1)->map->value;
    }
}
