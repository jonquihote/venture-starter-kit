<?php

namespace Venture\Home\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Venture\Home\Enums\UserCredentialTypesEnum;
use Venture\Home\Models\User;
use Venture\Home\Models\UserCredential;

/**
 * @extends Factory<UserCredential>
 */
class UserCredentialFactory extends Factory
{
    protected $model = UserCredential::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),

            'is_primary' => true,

            'verified_at' => Carbon::now(),
        ];
    }

    public function username(?string $username = null): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => UserCredentialTypesEnum::USERNAME,
            'value' => $username ?? fake()->userName(),
        ]);
    }

    public function email(?string $email = null): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => UserCredentialTypesEnum::EMAIL,
            'value' => $email ?? fake()->safeEmail(),
        ]);
    }

    public function secondary(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_primary' => false,
        ]);
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'verified_at' => null,
        ]);
    }
}
