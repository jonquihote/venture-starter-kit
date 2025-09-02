<?php

namespace Venture\Home\Filament\Clusters\Administration\Resources\Subscriptions\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\Width;
use Venture\Home\Filament\Clusters\Administration\Resources\Subscriptions\SubscriptionResource;

class ManageSubscriptions extends ManageRecords
{
    protected static string $resource = SubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalWidth(Width::Medium),
        ];
    }
}
