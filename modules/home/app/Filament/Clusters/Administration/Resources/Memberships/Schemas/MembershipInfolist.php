<?php

namespace Venture\Home\Filament\Clusters\Administration\Resources\Memberships\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;

class MembershipInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make()
                    ->schema([
                        TextEntry::make('account.name')
                            ->label(__('home::filament/resources/membership/infolist.entries.account.label')),

                        TextEntry::make('team.name')
                            ->label(__('home::filament/resources/membership/infolist.entries.team.label')),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
