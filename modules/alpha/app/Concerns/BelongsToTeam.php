<?php

namespace Venture\Alpha\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Venture\Alpha\Models\Team;

trait BelongsToTeam
{
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
