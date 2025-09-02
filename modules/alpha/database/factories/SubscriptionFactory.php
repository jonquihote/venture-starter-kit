<?php

namespace Venture\Alpha\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Venture\Alpha\Models\Application;
use Venture\Alpha\Models\Subscription;
use Venture\Alpha\Models\Team;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Venture\Alpha\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition(): array
    {
        return [
            'team_id' => Team::factory(),
            'application_id' => Application::factory(),
        ];
    }
}
