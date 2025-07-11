<?php

namespace Venture\Guide\Enums\Auth;

use Illuminate\Support\Collection;
use Venture\Guide\Enums\Auth\Permissions\PagePermissionsEnum;

enum PermissionsEnum
{
    public static function all(): Collection
    {
        return Collection::make([
            PagePermissionsEnum::all(),
        ])
            ->flatten(1)
            ->map
            ->value;
    }
}
