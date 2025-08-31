<?php

namespace Venture\Home\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Venture\Home\Database\Factories\Concerns\GeneratesValidUsernames;
use Venture\Home\Enums\AccountCredentialTypesEnum;
use Venture\Home\Models\Account;
use Venture\Home\Models\AccountCredential;

/**
 * @extends Factory<AccountCredential>
 */
class AccountCredentialFactory extends Factory
{
    use GeneratesValidUsernames;

    protected $model = AccountCredential::class;

    public function definition(): array
    {
        return [
            'account_id' => Account::factory(),

            'verified_at' => null,

            'is_primary' => true,
        ];
    }

    public function username(?string $username = null): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => AccountCredentialTypesEnum::Username,
            'value' => $username ?? $this->generateValidUsername(),
        ]);
    }

    public function email(?string $email = null): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => AccountCredentialTypesEnum::Email,
            'value' => $email ?? $this->faker->safeEmail(),
        ]);
    }

    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'verified_at' => Carbon::now(),
        ]);
    }

    public function secondary(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_primary' => false,
        ]);
    }
}
