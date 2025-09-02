<?php

namespace Venture\Alpha\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Venture\Alpha\Models\Team;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Venture\Alpha\Models\Team>
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
