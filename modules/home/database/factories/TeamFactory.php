<?php

namespace Venture\Home\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Venture\Home\Models\Team;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Venture\Home\Models\Team>
 */
class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
        ];
    }
}
