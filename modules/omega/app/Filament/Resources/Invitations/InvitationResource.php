<?php

namespace Venture\Omega\Filament\Resources\Invitations;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Venture\Omega\Filament\Resources\Invitations\Pages\CreateInvitation;
use Venture\Omega\Filament\Resources\Invitations\Pages\EditInvitation;
use Venture\Omega\Filament\Resources\Invitations\Pages\ListInvitations;
use Venture\Omega\Filament\Resources\Invitations\Pages\ViewInvitation;
use Venture\Omega\Filament\Resources\Invitations\Schemas\InvitationForm;
use Venture\Omega\Filament\Resources\Invitations\Schemas\InvitationInfolist;
use Venture\Omega\Filament\Resources\Invitations\Tables\InvitationsTable;
use Venture\Omega\Models\Invitation;

class InvitationResource extends Resource
{
    protected static ?string $model = Invitation::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return InvitationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InvitationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InvitationsTable::configure($table);
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
            'index' => ListInvitations::route('/'),
            'create' => CreateInvitation::route('/create'),
            'view' => ViewInvitation::route('/{record}'),
            'edit' => EditInvitation::route('/{record}/edit'),
        ];
    }
}
