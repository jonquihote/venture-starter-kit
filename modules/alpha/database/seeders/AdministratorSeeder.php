<?php

namespace Venture\Alpha\Database\Seeders;

use BackedEnum;
use Illuminate\Database\Seeder;
use Venture\Aeon\Facades\Access;
use Venture\Alpha\Enums\Auth\RolesEnum;
use Venture\Alpha\Models\Account;

class AdministratorSeeder extends Seeder
{
    public function run(): void
    {
        $account = Account::query()
            ->whereUsername('zeus')
            ->whereEmail('zeus@example.com')
            ->first();

        $team = $account->ownedTeams()->first();

        setPermissionsTeamId($team);

        $roles = Access::administratorRoles()
            ->reject(function (BackedEnum $role) {
                return $role === RolesEnum::Administrator;
            })
            ->push(RolesEnum::SuperAdministrator);

        $account->syncRoles($roles);
    }
}
