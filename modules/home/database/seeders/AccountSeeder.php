<?php

namespace Venture\Home\Database\Seeders;

use Illuminate\Database\Seeder;
use Venture\Aeon\Facades\Access;
use Venture\Home\Models\Account;
use Venture\Home\Models\AccountCredential;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        $account = Account::factory()
            ->has(AccountCredential::factory()->verified()->username('zeus'), 'credentials')
            ->has(AccountCredential::factory()->verified()->email('zeus@example.com'), 'credentials')
            ->create([
                'name' => 'Zeus',
            ]);

        $account->syncRoles(Access::administratorRoles());
    }
}
