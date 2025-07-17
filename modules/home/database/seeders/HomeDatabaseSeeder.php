<?php

namespace Venture\Home\Database\Seeders;

use Illuminate\Database\Seeder;

class HomeDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            TemporaryFileSeeder::class,
        ]);
    }
}
