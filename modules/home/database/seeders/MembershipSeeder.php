<?php

namespace Venture\Home\Database\Seeders;

use Illuminate\Database\Seeder;
use Venture\Home\Models\Account;
use Venture\Home\Models\Membership;
use Venture\Home\Models\Team;

class MembershipSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = Account::all();

        Team::all()
            ->each(function (Team $team) use ($accounts): void {
                $accounts
                    ->reject(function (Account $account) use ($team) {
                        return $team->owner->is($account);
                    })
                    ->each(function (Account $account) use ($team): void {
                        Membership::factory()->create([
                            'account_id' => $account,
                            'team_id' => $team,
                        ]);
                    });
            });
    }
}
