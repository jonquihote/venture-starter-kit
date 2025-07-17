<?php

namespace Venture\Home\Filament\Resources\TemporaryFileResource;

use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Lorisleiva\Actions\Action;
use Venture\Home\Filament\Resources\TemporaryFileResource\Tables\Actions\DownloadAction;

class ConfigureTemporaryFileResourceTableSchema extends Action
{
    protected string $langPre = 'home::filament/resources/temporary-file/table';

    protected function getColumns(): array
    {
        return [
            TextColumn::make('media.file_name')
                ->label("{$this->langPre}.columns.media.label")
                ->translateLabel()
                ->searchable()
                ->sortable(),

            TextColumn::make('downloads_count')
                ->label("{$this->langPre}.columns.downloads_count.label")
                ->translateLabel()
                ->sortable(),
        ];
    }

    public function handle(Table $table): Table
    {
        return $table
            ->columns($this->getColumns())
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),

                DownloadAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
