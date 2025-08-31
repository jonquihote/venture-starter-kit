<?php

namespace Venture\Home\Filament\Resources\Accounts\Pages;

use Filament\Actions\ActionGroup;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Venture\Home\Filament\Resources\Accounts\AccountResource;
use Venture\Home\Filament\Resources\Accounts\Actions\EditPasswordAction;
use Venture\Home\Filament\Resources\Accounts\Actions\EditRolesAction;

class ViewAccount extends ViewRecord
{
    protected static string $resource = AccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                EditAction::make()
                    ->label(__('home::filament/resources/account/actions/edit.label')),

                EditPasswordAction::make(),
                EditRolesAction::make(),
            ])->button(),
        ];
    }
}
