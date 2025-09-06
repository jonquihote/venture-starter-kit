<?php

namespace Venture\Blueprint\Enums\Auth;

use Illuminate\Support\Collection;
use Venture\Blueprint\Enums\Auth\Permissions\PagePermissionsEnum;
use Venture\Blueprint\Enums\Auth\Permissions\PostPermissionsEnum;

enum RolesEnum: string
{
    case Administrator = 'blueprint::authorization/roles.administrator';
    case User = 'blueprint::authorization/roles.user';

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
                PostPermissionsEnum::all(),
            ],
            self::User => [
                PagePermissionsEnum::all(),
            ],
        };

        return Collection::make($permissions)->flatten(1);
    }
}
