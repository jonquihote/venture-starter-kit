<?php

namespace Venture\Home\Filament\Clusters\Administration\Resources\Memberships\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\Width;
use Venture\Home\Filament\Clusters\Administration\Resources\Memberships\MembershipResource;

class ManageMemberships extends ManageRecords
{
    protected static string $resource = MembershipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalWidth(Width::Medium),
        ];
    }
}
