<?php

namespace Venture\Home\Filament\Resources;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Venture\Home\Filament\Resources\TemporaryFileResource\ConfigureTemporaryFileResourceTableSchema;
use Venture\Home\Filament\Resources\TemporaryFileResource\Pages;
use Venture\Home\Models\TemporaryFile;

class TemporaryFileResource extends Resource
{
    protected static ?string $model = TemporaryFile::class;

    protected static ?string $slug = 'temporary-files';

    protected static ?string $navigationIcon = 'fad:sharp-files';

    protected static ?int $navigationSort = 200;

    public static function form(Form $form): Form
    {
        return $form;
    }

    public static function table(Table $table): Table
    {
        return ConfigureTemporaryFileResourceTableSchema::run($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTemporaryFiles::route('/'),
            'create' => Pages\CreateTemporaryFile::route('/create'),
            'edit' => Pages\EditTemporaryFile::route('/{record}/edit'),
        ];
    }
}
