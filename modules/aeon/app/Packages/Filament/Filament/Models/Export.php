<?php

namespace Venture\Aeon\Packages\Filament\Filament\Models;

use Filament\Actions\Exports\Models\Export as BaseExport;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Venture\Alpha\Models\Account;

/**
 * @codeCoverageIgnore
 *
 * This file exists to accommodate `filament_` prefix in the database table that handles exports.
 */
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
