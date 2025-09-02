<?php

namespace Venture\Alpha\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Venture\Alpha\Models\Attachment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Venture\Alpha\Models\Attachment>
 */
class AttachmentFactory extends Factory
{
    protected $model = Attachment::class;

    public function definition(): array
    {
        $slug = $this->faker->word();
        $name = Str::title($slug);

        return [
            'name' => $name,
            'slug' => $slug,
            'description' => $this->faker->paragraph(),
            'downloads_count' => 0,
        ];
    }
}
