<?php

namespace Venture\Home\Models\Account\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Venture\Home\Enums\AccountCredentialTypesEnum;
use Venture\Home\Models\AccountCredential;

trait InteractsWithCredentials
{
    public function credentials(): HasMany
    {
        return $this->hasMany(AccountCredential::class);
    }

    public function email(): HasOne
    {
        return $this->hasOne(AccountCredential::class)
            ->where('type', AccountCredentialTypesEnum::Email)
            ->where('is_primary', true);
    }

    public function username(): HasOne
    {
        return $this->hasOne(AccountCredential::class)
            ->where('type', AccountCredentialTypesEnum::Username)
            ->where('is_primary', true);
    }

    public function updateUsername(string $value): Model
    {
        return $this->credentials()->updateOrCreate(
            [
                'value' => $value,
                'type' => AccountCredentialTypesEnum::Username,
            ],
            [
                'is_primary' => true,
                'verified_at' => Carbon::now(),
            ]
        );
    }

    public function updateEmail(string $value): Model
    {
        return $this->credentials()->updateOrCreate(
            [
                'value' => $value,
                'type' => AccountCredentialTypesEnum::Email,
            ],
            [
                'is_primary' => true,
                'verified_at' => null,
            ]
        );
    }

    public function scopeWhereUsername(Builder $query, string $value): Builder
    {
        return $query
            ->whereHas('credentials', function (Builder $query) use ($value): void {
                $query
                    ->where('type', AccountCredentialTypesEnum::Username)
                    ->where('value', $value)
                    ->where('is_primary', true);
            });
    }

    public function scopeWhereEmail(Builder $query, string $value): Builder
    {
        return $query
            ->whereHas('credentials', function (Builder $query) use ($value): void {
                $query
                    ->where('type', AccountCredentialTypesEnum::Email)
                    ->where('value', $value)
                    ->where('is_primary', true);
            });
    }
}
