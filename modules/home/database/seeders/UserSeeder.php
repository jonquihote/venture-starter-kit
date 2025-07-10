<?php

namespace Venture\Home\Database\Seeders;

use Illuminate\Database\Seeder;
use Venture\Aeon\Support\Facades\Access;
use Venture\Home\Models\User;
use Venture\Home\Models\UserCredential;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()
            ->has(UserCredential::factory()->username('zeus'), 'credentials')
            ->has(UserCredential::factory()->email('zeus@example.com'), 'credentials')
            ->create([
                'name' => 'Zeus',
            ]);

        $user->syncRoles(Access::administratorRoles());

        User::factory()
            ->has(UserCredential::factory()->username(), 'credentials')
            ->has(UserCredential::factory()->email(), 'credentials')
            ->count(10)
            ->create();
    }
}
