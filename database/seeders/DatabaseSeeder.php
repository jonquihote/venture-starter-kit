<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Venture\Aeon\Database\Seeders\AeonDatabaseSeeder;
use Venture\Guide\Database\Seeders\GuideDatabaseSeeder;
use Venture\Home\Database\Seeders\HomeDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AeonDatabaseSeeder::class,
            HomeDatabaseSeeder::class,
            GuideDatabaseSeeder::class,
        ]);
    }
}
