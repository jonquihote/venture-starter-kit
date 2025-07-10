<?php

namespace Venture\Aeon\Auth\Concerns;

use BackedEnum;
use Illuminate\Support\Collection;

trait InteractsWithPermissionsEnum
{
    public static function all(): Collection
    {
        return Collection::make(self::cases());
    }

    public static function only(...$permissions): Collection
    {
        $permissions = Collection::make($permissions);

        return self::all()
            ->filter(function (BackedEnum $permission) use ($permissions) {
                return $permissions->contains(function (BackedEnum $enum) use ($permission) {
                    return $enum->value === $permission->value;
                });
            });
    }

    public static function except(...$permissions): Collection
    {
        $permissions = Collection::make($permissions);

        return Collection::make(self::cases())
            ->reject(function (BackedEnum $permission) use ($permissions) {
                return $permissions->contains(function (BackedEnum $enum) use ($permission) {
                    return $enum->value === $permission->value;
                });
            });
    }
}
