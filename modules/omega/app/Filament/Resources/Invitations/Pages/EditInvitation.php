<?php

namespace Venture\Omega\Filament\Resources\Invitations\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Venture\Omega\Filament\Resources\Invitations\InvitationResource;

class EditInvitation extends EditRecord
{
    protected static string $resource = InvitationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
