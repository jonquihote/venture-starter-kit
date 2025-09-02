<?php

namespace Venture\Alpha\Filament\Clusters\Administration\Resources\Teams;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Venture\Alpha\Filament\Clusters\Administration\AdministrationCluster;
use Venture\Alpha\Filament\Clusters\Administration\Resources\Teams\Pages\CreateTeam;
use Venture\Alpha\Filament\Clusters\Administration\Resources\Teams\Pages\EditTeam;
use Venture\Alpha\Filament\Clusters\Administration\Resources\Teams\Pages\ListTeams;
use Venture\Alpha\Filament\Clusters\Administration\Resources\Teams\Pages\ViewTeam;
use Venture\Alpha\Filament\Clusters\Administration\Resources\Teams\RelationManagers\MembershipsRelationManager;
use Venture\Alpha\Filament\Clusters\Administration\Resources\Teams\Schemas\TeamForm;
use Venture\Alpha\Filament\Clusters\Administration\Resources\Teams\Schemas\TeamInfolist;
use Venture\Alpha\Filament\Clusters\Administration\Resources\Teams\Tables\TeamsTable;
use Venture\Alpha\Models\Team;

class TeamResource extends Resource
{
    protected static ?string $cluster = AdministrationCluster::class;

    protected static ?string $model = Team::class;

    protected static string | BackedEnum | null $navigationIcon = 'lucide-combine';

    protected static ?int $navigationSort = 200;

    protected static bool $isScopedToTenant = false;

    public static function form(Schema $schema): Schema
    {
        return TeamForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TeamInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TeamsTable::configure($table);
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
            'index' => ListTeams::route('/'),
            'create' => CreateTeam::route('/create'),
            'view' => ViewTeam::route('/{record}'),
            'edit' => EditTeam::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('alpha::filament/resources/team.navigation.label');
    }

    public static function getModelLabel(): string
    {
        return __('alpha::filament/resources/team.labels.single');
    }

    public static function getPluralModelLabel(): string
    {
        return __('alpha::filament/resources/team.labels.plural');
    }
}
