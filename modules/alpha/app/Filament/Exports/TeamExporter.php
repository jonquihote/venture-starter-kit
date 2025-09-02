<?php

namespace Venture\Alpha\Filament\Exports;

use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;
use Venture\Alpha\Models\Team;

class TeamExporter extends Exporter
{
    protected static ?string $model = Team::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')
                ->label(__('alpha::filament/resources/team/table.columns.name.label')),

            ExportColumn::make('owner.name')
                ->label(__('alpha::filament/resources/team/table.columns.owner.label')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your team export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
