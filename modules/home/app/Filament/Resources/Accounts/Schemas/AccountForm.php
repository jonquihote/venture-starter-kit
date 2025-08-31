<?php

namespace Venture\Home\Filament\Resources\Accounts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Venture\Home\Enums\AccountCredentialTypesEnum;
use Venture\Home\Rules\ValidName;
use Venture\Home\Rules\ValidUsername;

class AccountForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->label(__('home::filament/resources/account/form.fields.name.label'))
                            ->required()
                            ->rules([
                                new ValidName,
                            ])
                            ->columnSpanFull(),

                        TextInput::make('password')
                            ->label(__('home::filament/resources/account/form.fields.password.label'))
                            ->password()
                            ->required()
                            ->confirmed()
                            ->revealable()
                            ->hiddenOn('edit')
                            ->columnSpan(1),

                        TextInput::make('password_confirmation')
                            ->label(__('home::filament/resources/account/form.fields.password_confirmation.label'))
                            ->password()
                            ->required()
                            ->revealable()
                            ->dehydrated(false)
                            ->hiddenOn('edit')
                            ->columnSpan(1),

                        Group::make()
                            ->schema([
                                TextInput::make('value')
                                    ->label(__('home::filament/resources/account/form.fields.username.label'))
                                    ->required()
                                    ->unique()
                                    ->minLength(4)
                                    ->maxLength(16)
                                    ->rules([
                                        new ValidUsername,
                                    ])
                                    ->columnSpan(1),
                            ])
                            ->relationship('username')
                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                                $data['type'] = AccountCredentialTypesEnum::Username;
                                $data['is_primary'] = true;

                                return $data;
                            }),

                        Group::make()
                            ->schema([
                                TextInput::make('value')
                                    ->label(__('home::filament/resources/account/form.fields.email.label'))
                                    ->required()
                                    ->email()
                                    ->unique()
                                    ->columnSpan(1),
                            ])
                            ->relationship('email')
                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                                $data['type'] = AccountCredentialTypesEnum::Email;
                                $data['is_primary'] = true;

                                return $data;
                            }),

                    ])
                    ->columnSpanFull()
                    ->columns(2),
            ]);
    }
}
