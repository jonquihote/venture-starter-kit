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

        Account::factory()
            ->has(AccountCredential::factory()->verified()->username('luffy'), 'credentials')
            ->has(AccountCredential::factory()->verified()->email('luffy@example.com'), 'credentials')
            ->create([
                'name' => 'Monkey D. Luffy',
            ]);

        Account::factory()
            ->has(AccountCredential::factory()->verified()->username('tanjiro'), 'credentials')
            ->has(AccountCredential::factory()->verified()->email('tanjiro@example.com'), 'credentials')
            ->create([
                'name' => 'Tanjiro Kamado',
            ]);

        Account::factory()
            ->has(AccountCredential::factory()->verified()->username('jin.woo'), 'credentials')
            ->has(AccountCredential::factory()->verified()->email('jin.woo@example.com'), 'credentials')
            ->create([
                'name' => 'Sung Jin Woo',
            ]);
    }
}
