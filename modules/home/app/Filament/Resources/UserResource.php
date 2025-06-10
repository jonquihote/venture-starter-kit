<?php

namespace Venture\Home\Filament\Resources;

use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Venture\Home\Filament\Resources\UserResource\InitializeFormSchema;
use Venture\Home\Filament\Resources\UserResource\InitializeInfoSchema;
use Venture\Home\Filament\Resources\UserResource\InitializeTableColumns;
use Venture\Home\Filament\Resources\UserResource\Pages;
use Venture\Home\Models\User;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $slug = 'users';

    protected static ?string $navigationIcon = 'fad:sharp-users';

    public static function form(Form $form): Form
    {
        return InitializeFormSchema::run($form);
    }

    public static function table(Table $table): Table
    {
        return InitializeTableColumns::run($table);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return InitializeInfoSchema::run($infolist);
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
