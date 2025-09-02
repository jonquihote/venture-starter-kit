<?php

namespace Venture\Alpha\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Venture\Alpha\Models\Application;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Venture\Alpha\Models\Application>
 */
class ApplicationFactory extends Factory
{
    protected $model = Application::class;

    public function definition(): array
    {
        $name = $this->faker->word();
        $slug = Str::slug($name);

        return [
            'name' => $name,
            'slug' => $slug,
            'icon' => 'lucide-house',
            'page' => 'Dashboard',

            'is_subscribed_by_default' => true,
        ];
    }
}
