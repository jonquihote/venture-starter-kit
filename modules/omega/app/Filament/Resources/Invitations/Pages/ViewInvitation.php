<?php

namespace Venture\Omega\Filament\Resources\Invitations\Pages;

use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Venture\Omega\Filament\Resources\Invitations\InvitationResource;

class ViewInvitation extends ViewRecord
{
    protected static string $resource = InvitationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
