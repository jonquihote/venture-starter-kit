<?php

namespace Venture\Home\Filament\Resources\UserResource\Pages;

use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Venture\Home\Filament\Resources\UserResource;
use Venture\Home\Filament\Resources\UserResource\Pages\ViewUser\PasswordAction;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),

            PasswordAction::make(),
        ];
    }
}
