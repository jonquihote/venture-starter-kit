<?php

namespace Venture\Home\Filament\Clusters\Administration\Resources\Accounts\Pages;

use Filament\Resources\Pages\CreateRecord;
use Venture\Home\Filament\Clusters\Administration\Resources\Accounts\AccountResource;

class CreateAccount extends CreateRecord
{
    protected static string $resource = AccountResource::class;
}
