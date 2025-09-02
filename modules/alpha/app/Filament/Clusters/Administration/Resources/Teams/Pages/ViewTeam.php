<?php

namespace Venture\Alpha\Filament\Clusters\Administration\Resources\Teams\Pages;

use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Venture\Alpha\Filament\Clusters\Administration\Resources\Teams\TeamResource;

class ViewTeam extends ViewRecord
{
    protected static string $resource = TeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
