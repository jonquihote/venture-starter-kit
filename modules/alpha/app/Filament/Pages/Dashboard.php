<?php

namespace Venture\Alpha\Filament\Pages;

use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Support\Facades\Auth;
use Venture\Alpha\Enums\Auth\Permissions\PagePermissionsEnum;

class Dashboard extends BaseDashboard
{
    protected static string | BackedEnum | null $navigationIcon = 'lucide-house';

    public static function getNavigationLabel(): string
    {
        return __('alpha::filament/pages/dashboard.navigation.label');
    }

    public function getTitle(): string
    {
        return __('alpha::filament/pages/dashboard.title');
    }

    public static function canAccess(): bool
    {
        return Auth::user()->can(PagePermissionsEnum::Dashboard);
    }
}
