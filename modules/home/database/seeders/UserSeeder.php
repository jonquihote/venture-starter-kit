<?php

namespace Venture\Home\Database\Seeders;

use Illuminate\Database\Seeder;
use Venture\Home\Enums\Auth\RolesEnum;
use Venture\Home\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Zeus',
            'email' => 'zeus@example.com',
        ]);

        $user->assignRole(RolesEnum::ADMINISTRATOR);

        User::factory()->count(10)->create();
    }
}
