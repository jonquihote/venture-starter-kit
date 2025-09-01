<?php

namespace Venture\Home\Filament\Clusters\Administration\Resources\Teams\Pages;

use Filament\Resources\Pages\CreateRecord;
use Venture\Home\Filament\Clusters\Administration\Resources\Teams\TeamResource;

class CreateTeam extends CreateRecord
{
    protected static string $resource = TeamResource::class;
}
