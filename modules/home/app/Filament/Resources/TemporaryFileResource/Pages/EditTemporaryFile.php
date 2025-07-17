<?php

namespace Venture\Home\Filament\Resources\TemporaryFileResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Venture\Home\Filament\Resources\TemporaryFileResource;

class EditTemporaryFile extends EditRecord
{
    protected static string $resource = TemporaryFileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
