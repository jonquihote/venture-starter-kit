<?php

namespace Venture\Aeon\Packages\Filament\Filament\Models;

use Filament\Actions\Imports\Models\FailedImportRow as BaseFailedImportRow;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FailedImportRow extends BaseFailedImportRow
{
    protected $table = 'filament_failed_import_rows';

    public function import(): BelongsTo
    {
        return $this->belongsTo(Import::class);
    }
}
