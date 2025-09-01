<?php

namespace Venture\Home\Filament\Resources\Accounts\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Venture\Home\Filament\Resources\Accounts\Actions\EditPasswordAction;
use Venture\Home\Filament\Resources\Accounts\Actions\EditRolesAction;
use Venture\Home\Filament\Resources\Accounts\Actions\ExportAction;
use Venture\Home\Filament\Resources\Accounts\Actions\ExportBulkAction;
use Venture\Home\Filament\Resources\Accounts\Actions\ImportAction;
use Venture\Home\Models\Account;

class AccountsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->searchUsing(function (Builder $query, string $search) {
                return $query->whereKey(Account::search($search)->keys());
            })
            ->columns([
                TextColumn::make('name')
                    ->label(__('home::filament/resources/account/table.columns.name.label')),

                TextColumn::make('username.value')
                    ->label(__('home::filament/resources/account/table.columns.username.label')),

                TextColumn::make('email.value')
                    ->label(__('home::filament/resources/account/table.columns.email.label')),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make()
                        ->label(__('home::filament/resources/account/actions/view.label')),

                    ActionGroup::make([
                        EditAction::make()
                            ->label(__('home::filament/resources/account/actions/edit.label')),

                        EditPasswordAction::make(),
                        EditRolesAction::make(),
                    ])->dropdown(false),
                ]),
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
