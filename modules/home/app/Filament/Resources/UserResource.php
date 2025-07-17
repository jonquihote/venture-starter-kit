<?php

namespace Venture\Home\Filament\Resources;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Venture\Home\Filament\Resources\UserResource\ConfigureUserResourceFormSchema;
use Venture\Home\Filament\Resources\UserResource\ConfigureUserResourceTableSchema;
use Venture\Home\Filament\Resources\UserResource\Pages;
use Venture\Home\Models\User;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $slug = 'users';

    protected static ?string $navigationIcon = 'fad:sharp-users';

    protected static ?int $navigationSort = 100;

    public static function form(Form $form): Form
    {
        return ConfigureUserResourceFormSchema::run($form);
    }

    public static function table(Table $table): Table
    {
        return ConfigureUserResourceTableSchema::run($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'view' => Pages\ViewUser::route('/{record}'),
        ];
    }
}
