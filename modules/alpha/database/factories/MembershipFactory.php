<?php

namespace Venture\Alpha\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Venture\Alpha\Models\Account;
use Venture\Alpha\Models\Membership;
use Venture\Alpha\Models\Team;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Venture\Alpha\Models\Membership>
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
