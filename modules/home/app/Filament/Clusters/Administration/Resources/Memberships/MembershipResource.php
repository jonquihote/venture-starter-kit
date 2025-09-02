<?php

namespace Venture\Home\Filament\Clusters\Administration\Resources\Memberships;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Venture\Home\Filament\Clusters\Administration\AdministrationCluster;
use Venture\Home\Filament\Clusters\Administration\Resources\Memberships\Pages\ManageMemberships;
use Venture\Home\Filament\Clusters\Administration\Resources\Memberships\Schemas\MembershipForm;
use Venture\Home\Filament\Clusters\Administration\Resources\Memberships\Schemas\MembershipInfolist;
use Venture\Home\Filament\Clusters\Administration\Resources\Memberships\Tables\MembershipsTable;
use Venture\Home\Models\Membership;

class MembershipResource extends Resource
{
    protected static ?string $cluster = AdministrationCluster::class;

    protected static ?string $model = Membership::class;

    protected static string | BackedEnum | null $navigationIcon = 'lucide-book-user';

    protected static ?int $navigationSort = 500;

    protected static bool $isScopedToTenant = false;

    public static function getModelLabel(): string
    {
        return __('home::filament/resources/membership.labels.single');
    }

    public static function getPluralModelLabel(): string
    {
        return __('home::filament/resources/membership.labels.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('home::filament/resources/membership.navigation.label');
    }

    public static function form(Schema $schema): Schema
    {
        return MembershipForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MembershipInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MembershipsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageMemberships::route('/'),
        ];
    }
}
