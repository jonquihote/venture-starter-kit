<?php

namespace Venture\Alpha\Filament\Clusters\Administration\Resources\Teams\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TeamInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('alpha::filament/resources/team/infolist.entries.name.label'))
                            ->columnSpanFull(),

                        TextEntry::make('owner.name')
                            ->label(__('alpha::filament/resources/team/infolist.entries.owner.label'))
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull()
                    ->columns(2),
            ]);
    }
}
