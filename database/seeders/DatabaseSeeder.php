<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Venture\Alpha\Database\Seeders\AlphaDatabaseSeeder;
use Venture\Blueprint\Database\Seeders\BlueprintDatabaseSeeder;
use Venture\Omega\Database\Seeders\OmegaDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AlphaDatabaseSeeder::class,
            BlueprintDatabaseSeeder::class,
            OmegaDatabaseSeeder::class,
        ]);
    }
}
