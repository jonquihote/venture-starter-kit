<?php

namespace Venture\Alpha\Database\Seeders;

use Illuminate\Database\Seeder;
use Venture\Alpha\Models\Account;
use Venture\Alpha\Models\AccountCredential;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        Account::factory()
            ->has(AccountCredential::factory()->verified()->username('zeus'), 'credentials')
            ->has(AccountCredential::factory()->verified()->email('zeus@example.com'), 'credentials')
            ->create([
                'name' => 'Zeus',
            ]);

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
