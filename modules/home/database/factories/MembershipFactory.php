<?php

namespace Venture\Home\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Venture\Home\Models\Account;
use Venture\Home\Models\Membership;
use Venture\Home\Models\Team;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Venture\Home\Models\Membership>
 */
class MembershipFactory extends Factory
{
    protected $model = Membership::class;

    public function definition(): array
    {
        return [
            'account_id' => Account::factory(),
            'team_id' => Team::factory(),
        ];
    }
}
