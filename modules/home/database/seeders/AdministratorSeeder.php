<?php

namespace Venture\Home\Database\Seeders;

use Illuminate\Database\Seeder;
use Venture\Aeon\Facades\Access;
use Venture\Home\Models\Account;

class AdministratorSeeder extends Seeder
{
    public function run(): void
    {
        $zeus = Account::query()
            ->whereUsername('zeus')
            ->whereEmail('zeus@example.com')
            ->first();

        $zeus->syncRoles(Access::administratorRoles());
    }
}
