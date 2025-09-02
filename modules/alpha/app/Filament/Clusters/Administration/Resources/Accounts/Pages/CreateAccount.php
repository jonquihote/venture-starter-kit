<?php

namespace Venture\Alpha\Filament\Clusters\Administration\Resources\Accounts\Pages;

use Filament\Resources\Pages\CreateRecord;
use Venture\Alpha\Filament\Clusters\Administration\Resources\Accounts\AccountResource;

class CreateAccount extends CreateRecord
{
    protected static string $resource = AccountResource::class;
}
