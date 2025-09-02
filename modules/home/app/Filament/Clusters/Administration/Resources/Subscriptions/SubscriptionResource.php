<?php

namespace Venture\Home\Filament\Clusters\Administration\Resources\Subscriptions;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Venture\Home\Filament\Clusters\Administration\AdministrationCluster;
use Venture\Home\Filament\Clusters\Administration\Resources\Subscriptions\Pages\ManageSubscriptions;
use Venture\Home\Filament\Clusters\Administration\Resources\Subscriptions\Schemas\SubscriptionForm;
use Venture\Home\Filament\Clusters\Administration\Resources\Subscriptions\Schemas\SubscriptionInfolist;
use Venture\Home\Filament\Clusters\Administration\Resources\Subscriptions\Tables\SubscriptionsTable;
use Venture\Home\Models\Subscription;

class SubscriptionResource extends Resource
{
    protected static ?string $cluster = AdministrationCluster::class;

    protected static ?string $model = Subscription::class;

    protected static string | BackedEnum | null $navigationIcon = 'lucide-calendar-check';

    protected static ?int $navigationSort = 400;

    protected static bool $isScopedToTenant = false;

    public static function getModelLabel(): string
    {
        return __('home::filament/resources/subscription.labels.single');
    }

    public static function getPluralModelLabel(): string
    {
        return __('home::filament/resources/subscription.labels.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('home::filament/resources/subscription.navigation.label');
    }

    public static function form(Schema $schema): Schema
    {
        return SubscriptionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SubscriptionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SubscriptionsTable::configure($table);
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
            'index' => ManageSubscriptions::route('/'),
        ];
    }
}
