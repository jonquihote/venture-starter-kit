<?php

namespace Venture\Skeleton\Enums\Auth;

use Illuminate\Support\Collection;
use Venture\Skeleton\Enums\Auth\Permissions\PagePermissionsEnum;

enum RolesEnum: string
{
    case ADMINISTRATOR = 'skeleton::authorization/roles.administrator';
    case USER = 'skeleton::authorization/roles.user';

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
            self::ADMINISTRATOR => [
                PagePermissionsEnum::all(),
            ],
            self::USER => [
                PagePermissionsEnum::all(),
            ],
        };

        return Collection::make($permissions)->flatten(1);
    }
}
