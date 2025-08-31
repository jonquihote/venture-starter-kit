<?php

namespace Venture\Aeon\Packages\Filament\Filament\Models;

use Filament\Actions\Exports\Models\Export as BaseExport;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Venture\Home\Models\Account;

class Export extends BaseExport
{
    protected $table = 'filament_exports';

    public function user(): BelongsTo
    {
        return $this->account();
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
