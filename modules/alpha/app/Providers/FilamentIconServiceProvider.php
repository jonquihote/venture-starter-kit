<?php

namespace Venture\Alpha\Providers;

use Filament\Actions\View\ActionsIconAlias;
use Filament\Support\Facades\FilamentIcon;
use Filament\View\PanelsIconAlias;
use Illuminate\Support\ServiceProvider;

class FilamentIconServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        FilamentIcon::register([
            ActionsIconAlias::EDIT_ACTION => 'lucide-square-pen',
            ActionsIconAlias::VIEW_ACTION => 'lucide-eye',

            PanelsIconAlias::THEME_SWITCHER_LIGHT_BUTTON => 'lucide-sun',
            PanelsIconAlias::THEME_SWITCHER_DARK_BUTTON => 'lucide-moon',
            PanelsIconAlias::THEME_SWITCHER_SYSTEM_BUTTON => 'lucide-monitor',
            PanelsIconAlias::USER_MENU_PROFILE_ITEM => 'lucide-circle-user-round',
            PanelsIconAlias::USER_MENU_LOGOUT_BUTTON => 'lucide-log-out',
        ]);
    }

    public function boot(): void {}
}
