<?php

namespace Venture\Alpha\Database\Seeders;

use Illuminate\Database\Seeder;
use Venture\Alpha\Models\Account;
use Venture\Alpha\Models\Team;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $zeus = Account::query()
            ->whereUsername('zeus')
            ->first();

        Team::factory()
            ->create([
                'name' => 'The Olympus',
                'owner_id' => $zeus->id,
            ]);

        // Create Thousand Sunny team owned by Luffy
        $luffy = Account::query()
            ->whereUsername('luffy')
            ->first();

        Team::factory()
            ->create([
                'name' => 'Thousand Sunny',
                'owner_id' => $luffy->id,
            ]);

        $tanjiro = Account::query()
            ->whereUsername('tanjiro')
            ->first();

        Team::factory()
            ->create([
                'name' => 'Mount Sagiri',
                'owner_id' => $tanjiro->id,
            ]);

        $jinWoo = Account::query()
            ->whereUsername('jin.woo')
            ->first();

        Team::factory()
            ->create([
                'name' => 'Double Dungeon',
                'owner_id' => $jinWoo->id,
            ]);
    }
}
