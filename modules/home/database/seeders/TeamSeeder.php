<?php

namespace Venture\Home\Database\Seeders;

use Illuminate\Database\Seeder;
use Venture\Home\Models\Account;
use Venture\Home\Models\Team;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $account = Account::query()
            ->whereUsername('zeus')
            ->first();

        Team::factory()
            ->create([
                'name' => 'The Olympus',
                'owner_id' => $account->id,
            ]);
    }
}
