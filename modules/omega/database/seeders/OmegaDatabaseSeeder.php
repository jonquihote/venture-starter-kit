<?php

namespace Venture\Omega\Database\Seeders;

use Illuminate\Database\Seeder;

class OmegaDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            InvitationSeeder::class,
        ]);
    }
}
