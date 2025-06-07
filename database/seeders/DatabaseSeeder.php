<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Venture\Aeon\Database\Seeders\AeonDatabaseSeeder;
use Venture\Home\Database\Seeders\HomeDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call(AeonDatabaseSeeder::class);
        $this->call(HomeDatabaseSeeder::class);
    }
}
