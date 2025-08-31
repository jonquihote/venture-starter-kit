<?php

namespace Venture\Aeon\Enum\Auth;

use Illuminate\Support\Collection;
use Venture\Aeon\Enum\Auth\Permissions\PagePermissionsEnum;

enum RolesEnum: string
{
    case Administrator = 'aeon::authorization/roles.administrator';
    case User = 'aeon::authorization/roles.user';

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
                // No permissions for User role
            ],
        };

        return Collection::make($permissions)->flatten(1);
    }
}
