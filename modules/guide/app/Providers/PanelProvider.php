<?php

namespace Venture\Guide\Providers;

use Filament\Panel;
use Filament\PanelProvider as BasePanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Venture\Aeon\Actions\InitializeFilamentPanel;
use Venture\Aeon\Enums\ModulesEnum;

class PanelProvider extends BasePanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return InitializeFilamentPanel::run($panel, ModulesEnum::GUIDE)
            ->colors([
                'primary' => Color::Stone,
            ])
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ]);
    }
}
