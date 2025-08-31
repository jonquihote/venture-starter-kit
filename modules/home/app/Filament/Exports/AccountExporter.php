<?php

namespace Venture\Home\Filament\Exports;

use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;
use Venture\Home\Models\Account;

class AccountExporter extends Exporter
{
    protected static ?string $model = Account::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')
                ->label(__('home::filament/resources/account/table.columns.name.label')),

            ExportColumn::make('username.value')
                ->label(__('home::filament/resources/account/table.columns.username.label')),

            ExportColumn::make('email.value')
                ->label(__('home::filament/resources/account/table.columns.email.label')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your account export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
