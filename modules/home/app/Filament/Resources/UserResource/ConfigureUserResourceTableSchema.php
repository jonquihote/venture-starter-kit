<?php

namespace Venture\Home\Filament\Resources\UserResource;

use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Action;

class ConfigureUserResourceTableSchema extends Action
{
    protected string $langPre = 'home::filament/resources/user/table';

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->label("{$this->langPre}.columns.name.label")
                ->translateLabel()
                ->searchable()
                ->sortable(),

            TextColumn::make('username.value')
                ->label("{$this->langPre}.columns.username.label")
                ->translateLabel()
                ->searchable()
                ->sortable(),

            TextColumn::make('email.value')
                ->label("{$this->langPre}.columns.email.label")
                ->translateLabel()
                ->searchable()
                ->sortable(),

            TextColumn::make('roles_count')
                ->label("{$this->langPre}.columns.roles_count.label")
                ->translateLabel()
                ->counts('roles'),
        ];
    }

    public function handle(Table $table): Table
    {
        return $table
            ->columns($this->getTableColumns())
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->checkIfRecordIsSelectableUsing(function (Model $record) {
                return ! Auth::user()->is($record);
            });
    }
}
