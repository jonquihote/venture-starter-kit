<?php

namespace Venture\Alpha\Filament\Clusters\Administration\Resources\Accounts\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Venture\Aeon\Packages\Spatie\Permission\Models\Role;

class AccountInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('alpha::filament/resources/account/infolist.entries.name.label'))
                            ->columnSpanFull(),

                        TextEntry::make('username.value')
                            ->label(__('alpha::filament/resources/account/infolist.entries.username.label'))
                            ->columnSpan(1),

                        TextEntry::make('email.value')
                            ->label(__('alpha::filament/resources/account/infolist.entries.email.label'))
                            ->columnSpan(1),
                    ])
                    ->columnSpanFull()
                    ->columns(2),

                Section::make(__('alpha::filament/resources/account/infolist.sections.roles.heading'))
                    ->schema(self::getRoleComponents())
                    ->columnSpanFull(),
            ]);
    }

    public static function getRoleComponents(): array
    {
        $roles = Role::all()
            ->mapToGroups(function (Role $role) {
                $group = Str::of($role->name)->before('::')->toString();

                return [$group => $role->name];
            })
            ->map(function (Collection $roles, string $group) {
                return Fieldset::make(__("{$group}::module.name"))
                    ->schema(function () use ($roles) {
                        return $roles
                            ->map(function (string $role) {
                                return IconEntry::make('roles')
                                    ->label(__($role))
                                    ->boolean()
                                    ->inlineLabel()
                                    ->state(function ($record) use ($role) {
                                        return $record->roles->pluck('name')->contains($role);
                                    });
                            })
                            ->toArray();
                    })
                    ->columns(1)
                    ->columnSpan(1);
            })
            ->toArray();

        return [
            Grid::make(2)->schema($roles),
        ];
    }
}
