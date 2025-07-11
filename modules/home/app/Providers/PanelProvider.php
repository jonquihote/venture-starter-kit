<?php

namespace Venture\Home\Providers;

use Filament\Panel;
use Filament\PanelProvider as BasePanelProvider;
use Filament\Support\Colors\Color;
use Venture\Aeon\Actions\InitializeFilamentPanel;
use Venture\Aeon\Enums\ModulesEnum;
use Venture\Home\Filament\Pages\Auth\Login;

class PanelProvider extends BasePanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return InitializeFilamentPanel::run($panel, ModulesEnum::HOME)
            ->default()
            ->login(Login::class)
            ->colors([
                'primary' => Color::Orange,
                'gray' => Color::Slate,
                'success' => Color::Emerald,
                'danger' => Color::Rose,
                'warning' => Color::Amber,
                'info' => Color::Blue,
            ]);
    }
}
