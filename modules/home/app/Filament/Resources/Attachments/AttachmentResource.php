<?php

namespace Venture\Home\Filament\Resources\Attachments;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Venture\Home\Filament\Resources\Attachments\Pages\ManageAttachments;
use Venture\Home\Filament\Resources\Attachments\Schemas\AttachmentForm;
use Venture\Home\Filament\Resources\Attachments\Tables\AttachmentsTable;
use Venture\Home\Models\Attachment;

class AttachmentResource extends Resource
{
    protected static ?string $model = Attachment::class;

    protected static string | BackedEnum | null $navigationIcon = 'lucide-files';

    protected static ?int $navigationSort = 100;

    protected static bool $isScopedToTenant = false;

    public static function form(Schema $schema): Schema
    {
        return AttachmentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AttachmentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageAttachments::route('/'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('home::filament/resources/attachment.navigation.label');
    }

    public static function getModelLabel(): string
    {
        return __('home::filament/resources/attachment.labels.single');
    }

    public static function getPluralModelLabel(): string
    {
        return __('home::filament/resources/attachment.labels.plural');
    }
}
