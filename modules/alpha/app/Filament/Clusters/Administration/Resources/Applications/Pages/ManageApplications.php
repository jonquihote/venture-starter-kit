<?php

namespace Venture\Alpha\Filament\Clusters\Administration\Resources\Applications\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Venture\Alpha\Filament\Clusters\Administration\Resources\Applications\ApplicationResource;

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
