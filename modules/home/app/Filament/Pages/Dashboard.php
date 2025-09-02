<?php

namespace Venture\Home\Filament\Pages;

use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static string | BackedEnum | null $navigationIcon = 'lucide-house';

    public static function getNavigationLabel(): string
    {
        return __('home::filament/pages/dashboard.navigation.label');
    }

    public function getTitle(): string
    {
        return __('home::filament/pages/dashboard.title');
    }
}
