<?php

namespace Venture\Alpha\Filament\Clusters\Administration\Resources\Accounts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EditPasswordForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('password')
                ->label(__('alpha::filament/resources/account/form.fields.password.label'))
                ->password()
                ->required()
                ->minLength(8)
                ->confirmed(),

            TextInput::make('password_confirmation')
                ->label(__('alpha::filament/resources/account/form.fields.password_confirmation.label'))
                ->password()
                ->required()
                ->dehydrated(false),
        ]);
    }
}
