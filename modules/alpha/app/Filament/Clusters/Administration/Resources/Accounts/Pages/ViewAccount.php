<?php

namespace Venture\Alpha\Filament\Clusters\Administration\Resources\Accounts\Pages;

use Filament\Actions\ActionGroup;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Venture\Alpha\Filament\Clusters\Administration\Resources\Accounts\AccountResource;
use Venture\Alpha\Filament\Clusters\Administration\Resources\Accounts\Actions\EditPasswordAction;
use Venture\Alpha\Filament\Clusters\Administration\Resources\Accounts\Actions\EditRolesAction;

class ViewAccount extends ViewRecord
{
    protected static string $resource = AccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                EditAction::make()
                    ->label(__('alpha::filament/resources/account/actions/edit.label')),

                EditPasswordAction::make(),
                EditRolesAction::make(),
            ])->button(),
        ];
    }
}
