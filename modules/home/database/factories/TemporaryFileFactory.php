<?php

namespace Venture\Home\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Venture\Home\Models\TemporaryFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Venture\Home\Models\TemporaryFile>
 */
class TemporaryFileFactory extends Factory
{
    protected $model = TemporaryFile::class;

    public function definition(): array
    {
        return [
            'downloads_count' => fake()->numberBetween(1, 10),
        ];
    }
}
