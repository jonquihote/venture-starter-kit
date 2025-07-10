<?php

namespace Venture\Home\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Venture\Home\Database\Factories\UserCredentialFactory;
use Venture\Home\Enums\MigrationsEnum;
use Venture\Home\Enums\UserCredentialTypesEnum;

#[UseFactory(UserCredentialFactory::class)]
class UserCredential extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',

        'type',
        'value',

        'is_primary',

        'verified_at',
    ];

    public function getTable(): string
    {
        return MigrationsEnum::USER_CREDENTIALS->table();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'type' => UserCredentialTypesEnum::class,

            'verified_at' => 'datetime',
        ];
    }
}
