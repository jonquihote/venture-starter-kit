<?php

namespace Venture\Home\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Venture\Home\Enums\MigrationsEnum;

class Subscription extends Model
{
    protected $fillable = [
        'team_id',
        'application_id',
    ];

    public function getTable(): string
    {
        return MigrationsEnum::Subscriptions->table();
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
