<?php

namespace Venture\Aeon\Packages\Filament\Filament\Models;

use Filament\Actions\Imports\Models\Import as BaseImport;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Venture\Alpha\Models\Account;

class Import extends BaseImport
{
    protected $table = 'filament_imports';

    public function user(): BelongsTo
    {
        return $this->account();
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function failedRows(): HasMany
    {
        return $this->hasMany(FailedImportRow::class);
    }
}
