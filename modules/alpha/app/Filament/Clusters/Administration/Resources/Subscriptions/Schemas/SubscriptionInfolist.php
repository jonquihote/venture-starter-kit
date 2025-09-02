<?php

namespace Venture\Alpha\Filament\Clusters\Administration\Resources\Subscriptions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;

class SubscriptionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make()
                    ->schema([
                        TextEntry::make('team.name')
                            ->label(__('alpha::filament/resources/subscription/infolist.entries.team.label')),

                        TextEntry::make('application.name')
                            ->label(__('alpha::filament/resources/subscription/infolist.entries.application.label')),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
