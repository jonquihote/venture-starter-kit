<?php

namespace Venture\Home\Filament\Clusters\Administration\Resources\Teams\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Venture\Home\Filament\Clusters\Administration\Resources\Teams\Actions\ExportAction;
use Venture\Home\Filament\Clusters\Administration\Resources\Teams\Actions\ExportBulkAction;
use Venture\Home\Filament\Clusters\Administration\Resources\Teams\Actions\ImportAction;

class TeamsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('home::filament/resources/team/table.columns.name.label'))
                    ->searchable(),

                TextColumn::make('owner.name')
                    ->label(__('home::filament/resources/team/table.columns.owner.label'))
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->headerActions([
                ImportAction::make(),
                ExportAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),

                    ExportBulkAction::make(),
                ]),
            ])
            ->striped()
            ->searchable();
    }
}
