<?php

namespace Venture\Home\Filament\Clusters\Administration\Resources\Applications;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Venture\Home\Filament\Clusters\Administration\AdministrationCluster;
use Venture\Home\Filament\Clusters\Administration\Resources\Applications\Pages\ManageApplications;
use Venture\Home\Filament\Clusters\Administration\Resources\Applications\Schemas\ApplicationForm;
use Venture\Home\Filament\Clusters\Administration\Resources\Applications\Schemas\ApplicationInfolist;
use Venture\Home\Filament\Clusters\Administration\Resources\Applications\Tables\ApplicationsTable;
use Venture\Home\Models\Application;

class ApplicationResource extends Resource
{
    protected static ?string $cluster = AdministrationCluster::class;

    protected static ?string $model = Application::class;

    protected static string | BackedEnum | null $navigationIcon = 'lucide-app-window';

    protected static ?int $navigationSort = 300;

    protected static bool $isScopedToTenant = false;

    public static function getModelLabel(): string
    {
        return __('home::filament/resources/application.labels.single');
    }

    public static function getPluralModelLabel(): string
    {
        return __('home::filament/resources/application.labels.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('home::filament/resources/application.navigation.label');
    }

    public static function form(Schema $schema): Schema
    {
        return ApplicationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ApplicationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ApplicationsTable::configure($table);
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
            'index' => ManageApplications::route('/'),
        ];
    }
}
