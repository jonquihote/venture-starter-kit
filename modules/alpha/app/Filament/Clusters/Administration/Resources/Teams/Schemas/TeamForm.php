<?php

namespace Venture\Alpha\Filament\Clusters\Administration\Resources\Teams\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Venture\Alpha\Models\Account;

class TeamForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->label(__('alpha::filament/resources/team/form.fields.name.label'))
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Select::make('owner_id')
                            ->label(__('alpha::filament/resources/team/form.fields.owner_id.label'))
                            ->options(Account::all()->pluck('name', 'id'))
                            ->required()
                            ->searchable()
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull()
                    ->columns(2),
            ]);
    }
}
