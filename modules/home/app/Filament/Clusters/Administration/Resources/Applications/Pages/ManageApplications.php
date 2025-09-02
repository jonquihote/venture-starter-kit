<?php

namespace Venture\Home\Filament\Clusters\Administration\Resources\Applications\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Venture\Home\Filament\Clusters\Administration\Resources\Applications\ApplicationResource;

class ManageApplications extends ManageRecords
{
    protected static string $resource = ApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
