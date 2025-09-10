<?php

namespace Venture\Alpha\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Venture\Alpha\Database\Factories\Concerns\GeneratesValidNames;
use Venture\Alpha\Database\Factories\Concerns\GeneratesValidUsernames;
use Venture\Alpha\Models\Account;

/**
 * @extends Factory<Account>
 */
class AccountFactory extends Factory
{
    use GeneratesValidNames;
    use GeneratesValidUsernames;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->generateValidName(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    public function credentials(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'username' => $this->generateValidUsername(),
                'email' => $this->faker->safeEmail(),
            ];
        });
    }
}
