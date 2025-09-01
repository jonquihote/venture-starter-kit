<?php

namespace Venture\Home\Filament\Clusters\Administration\Resources\Accounts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EditPasswordForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('password')
                ->label(__('home::filament/resources/account/form.fields.password.label'))
                ->password()
                ->required()
                ->minLength(8)
                ->confirmed(),

            TextInput::make('password_confirmation')
                ->label(__('home::filament/resources/account/form.fields.password_confirmation.label'))
                ->password()
                ->required()
                ->dehydrated(false),
        ]);
    }
}
