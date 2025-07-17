<?php

namespace Venture\Home\Enums\Auth;

use Illuminate\Support\Collection;
use Venture\Home\Enums\Auth\Permissions\PagePermissionsEnum;
use Venture\Home\Enums\Auth\Permissions\TemporaryFileResourcePermissionsEnum;
use Venture\Home\Enums\Auth\Permissions\UserResourcePermissionsEnum;

enum RolesEnum: string
{
    case ADMINISTRATOR = 'home::authorization/roles.administrator';
    case USER = 'home::authorization/roles.user';

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

                UserResourcePermissionsEnum::all(),
                TemporaryFileResourcePermissionsEnum::only(
                    TemporaryFileResourcePermissionsEnum::VIEW_ANY,
                ),
            ],
            self::USER => [
                PagePermissionsEnum::all(),
            ],
        };

        return Collection::make($permissions)->flatten(1);
    }
}
