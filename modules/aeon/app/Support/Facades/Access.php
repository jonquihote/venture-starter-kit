<?php

namespace Venture\Aeon\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Venture\Aeon\Auth\AccessManager;

class Access extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return AccessManager::class;
    }
}
