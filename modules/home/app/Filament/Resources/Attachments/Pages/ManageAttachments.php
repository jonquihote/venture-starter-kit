<?php

namespace Venture\Home\Filament\Resources\Attachments\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Venture\Home\Filament\Resources\Attachments\AttachmentResource;

class ManageAttachments extends ManageRecords
{
    protected static string $resource = AttachmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
