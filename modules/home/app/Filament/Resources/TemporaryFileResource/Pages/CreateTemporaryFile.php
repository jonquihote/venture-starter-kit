<?php

namespace Venture\Home\Filament\Resources\TemporaryFileResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Venture\Home\Filament\Resources\TemporaryFileResource;

class CreateTemporaryFile extends CreateRecord
{
    protected static string $resource = TemporaryFileResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
