<?php

namespace Venture\Home\Filament\Resources\Attachments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Venture\Home\Filament\Resources\Attachments\Actions\DownloadAction;

class AttachmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('home::filament/resources/attachment/table.columns.name.label')),

                TextColumn::make('file_name')
                    ->label(__('home::filament/resources/attachment/table.columns.file_name.label')),

                TextColumn::make('downloads_count')
                    ->label(__('home::filament/resources/attachment/table.columns.downloads_count.label'))
                    ->numeric(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),

                DownloadAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
