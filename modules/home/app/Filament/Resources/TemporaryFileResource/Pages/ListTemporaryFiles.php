<?php

namespace Venture\Home\Filament\Resources\TemporaryFileResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Venture\Home\Filament\Resources\TemporaryFileResource;

class ListTemporaryFiles extends ListRecords
{
    protected static string $resource = TemporaryFileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
