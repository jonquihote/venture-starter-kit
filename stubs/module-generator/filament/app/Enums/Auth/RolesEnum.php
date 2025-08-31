<?php

namespace Venture\{Module}\Enums\Auth;

use Illuminate\Support\Collection;
use Venture\{Module}\Enums\Auth\Permissions\PagePermissionsEnum;
use Venture\{Module}\Enums\Auth\Permissions\UserPermissionsEnum;

enum RolesEnum: string
{
    case Administrator = '{module}::authorization/roles.administrator';
    case User = '{module}::authorization/roles.user';

    public static function all(): Collection
    {
        return Collection::make(self::cases())
            ->mapWithKeys(function (RolesEnum $role) {
                return [
                    $role->value => $role->permissions(),
                ];
            });
    }

    public function permissions(): Collection
    {
        $permissions = match ($this) {
            self::Administrator => [
                PagePermissionsEnum::all(),
            ],
            self::User => [
                PagePermissionsEnum::all(),
            ],
        };

        return Collection::make($permissions)->flatten(1);
    }
}
