<?php

namespace Venture\Alpha\Filament\Clusters\Administration\Resources\Teams\Pages;

use Filament\Resources\Pages\CreateRecord;
use Venture\Alpha\Filament\Clusters\Administration\Resources\Teams\TeamResource;

class CreateTeam extends CreateRecord
{
    protected static string $resource = TeamResource::class;
}
