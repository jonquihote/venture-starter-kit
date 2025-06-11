<?php

namespace Venture\Skeleton\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Support\Facades\Auth;
use Venture\Skeleton\Enums\Auth\Permissions\PagePermissionsEnum;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'fad:sharp-gauge';

    public static function canAccess(): bool
    {
        return Auth::user()->can(PagePermissionsEnum::DASHBOARD);
    }
}
