<?php

namespace Venture\Aeon\Tests\Stubs;

use Illuminate\Support\Collection;

enum RolesEnum: string
{
    case Administrator = 'administrator';
    case User = 'user';

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
                PagePermissionsEnum::only(
                    PagePermissionsEnum::Dashboard,
                ),
                AccountPermissionsEnum::except(
                    AccountPermissionsEnum::Delete,
                ),
            ],
            self::User => [
                PagePermissionsEnum::only(
                    PagePermissionsEnum::Dashboard,
                ),
            ],
        };

        return Collection::make($permissions)->flatten(1);
    }
}
