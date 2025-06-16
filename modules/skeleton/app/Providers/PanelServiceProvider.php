<?php

namespace Venture\Skeleton\Providers;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Venture\Aeon\Actions\InitializeFilamentPanel;
use Venture\Aeon\Enums\ModulesEnum;

class PanelServiceProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return InitializeFilamentPanel::run($panel, ModulesEnum::SKELETON)
            ->colors([
                'primary' => Color::Purple,
            ])
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ]);
    }
}
