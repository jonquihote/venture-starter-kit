<?php

namespace Venture\Home\Filament\Clusters\Administration\Resources\Accounts;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Venture\Home\Filament\Clusters\Administration\AdministrationCluster;
use Venture\Home\Filament\Clusters\Administration\Resources\Accounts\Pages\CreateAccount;
use Venture\Home\Filament\Clusters\Administration\Resources\Accounts\Pages\EditAccount;
use Venture\Home\Filament\Clusters\Administration\Resources\Accounts\Pages\ListAccounts;
use Venture\Home\Filament\Clusters\Administration\Resources\Accounts\Pages\ViewAccount;
use Venture\Home\Filament\Clusters\Administration\Resources\Accounts\RelationManagers\MembershipsRelationManager;
use Venture\Home\Filament\Clusters\Administration\Resources\Accounts\Schemas\AccountForm;
use Venture\Home\Filament\Clusters\Administration\Resources\Accounts\Schemas\AccountInfolist;
use Venture\Home\Filament\Clusters\Administration\Resources\Accounts\Tables\AccountsTable;
use Venture\Home\Models\Account;

class AccountResource extends Resource
{
    protected static ?string $cluster = AdministrationCluster::class;

    protected static ?string $model = Account::class;

    protected static string | BackedEnum | null $navigationIcon = 'lucide-users-round';

    protected static bool $isScopedToTenant = false;

    public static function form(Schema $schema): Schema
    {
        return AccountForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AccountInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AccountsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            MembershipsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAccounts::route('/'),
            'create' => CreateAccount::route('/create'),
            'view' => ViewAccount::route('/{record}'),
            'edit' => EditAccount::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('home::filament/resources/account.navigation.label');
    }

    public static function getModelLabel(): string
    {
        return __('home::filament/resources/account.labels.single');
    }

    public static function getPluralModelLabel(): string
    {
        return __('home::filament/resources/account.labels.plural');
    }
}
