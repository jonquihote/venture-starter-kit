<?php

namespace Venture\Home\Providers;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Venture\Aeon\Actions\InitializeFilamentPanel;
use Venture\Aeon\Enums\ModulesEnum;

class PanelServiceProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return InitializeFilamentPanel::run($panel, ModulesEnum::HOME)
            ->default()
            ->login()
            ->colors([
                'primary' => Color::Orange,
            ]);
    }
}
