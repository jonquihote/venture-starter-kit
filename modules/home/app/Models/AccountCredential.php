<?php

namespace Venture\Home\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Venture\Home\Database\Factories\AccountCredentialFactory;
use Venture\Home\Enums\AccountCredentialTypesEnum;
use Venture\Home\Enums\MigrationsEnum;

#[UseFactory(AccountCredentialFactory::class)]
class AccountCredential extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',

        'type',
        'value',

        'verified_at',

        'is_primary',
    ];

    public function getTable(): string
    {
        return MigrationsEnum::AccountCredentials->table();
    }

    protected function casts(): array
    {
        return [
            'type' => AccountCredentialTypesEnum::class,

            'verified_at' => 'datetime',
        ];
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
