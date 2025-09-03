<?php

namespace Venture\Omega\Filament\Resources\Invitations\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Venture\Omega\Filament\Resources\Invitations\InvitationResource;

class ListInvitations extends ListRecords
{
    protected static string $resource = InvitationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
