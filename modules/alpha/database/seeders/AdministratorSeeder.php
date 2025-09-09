<?php

namespace Venture\Alpha\Database\Seeders;

use BackedEnum;
use Illuminate\Database\Seeder;
use Venture\Aeon\Facades\Access;
use Venture\Alpha\Enums\Auth\RolesEnum;
use Venture\Alpha\Models\Account;
use Venture\Alpha\Settings\TenancySettings;

class AdministratorSeeder extends Seeder
{
    public function run(): void
    {
        $this->initializeSuperAdministrator();
        //        $this->initializeSingleTeamMode();
    }

    protected function initializeSuperAdministrator(): void
    {
        [$account, $team] = $this->getDefaultAccountAndTeam();

        setPermissionsTeamId($team);

        $roles = Access::administratorRoles()
            ->reject(function (BackedEnum $role) {
                return $role === RolesEnum::Administrator;
            })
            ->push(RolesEnum::SuperAdministrator);

        $account->syncRoles($roles);
    }

    protected function initializeSingleTeamMode(): void
    {
        [$_, $team] = $this->getDefaultAccountAndTeam();

        $settings = app(TenancySettings::class);

        $settings->is_single_team_mode = true;
        $settings->default_team_id = $team->getKey();
        $settings->save();
    }

    public function getDefaultAccountAndTeam(): array
    {
        $account = Account::query()
            ->whereUsername('zeus')
            ->whereEmail('zeus@example.com')
            ->first();

        $team = $account->ownedTeams()->first();

        return [$account, $team];
    }
}
