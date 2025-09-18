<?php

namespace Venture\Sigma\Enums\Auth;

use Illuminate\Support\Collection;
use Venture\Sigma\Enums\Auth\Permissions\PagePermissionsEnum;

enum RolesEnum: string
{
    case Administrator = 'sigma::authorization/roles.administrator';
    case User = 'sigma::authorization/roles.user';

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
