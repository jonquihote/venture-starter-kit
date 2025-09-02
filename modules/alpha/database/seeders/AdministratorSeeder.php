<?php

namespace Venture\Alpha\Database\Seeders;

use Illuminate\Database\Seeder;
use Venture\Alpha\Models\Account;

class AdministratorSeeder extends Seeder
{
    public function run(): void
    {
        $zeus = Account::query()
            ->whereUsername('zeus')
            ->whereEmail('zeus@example.com')
            ->first();
    }
}
