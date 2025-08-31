<?php

namespace Venture\Blueprint\Providers;

use Filament\Panel;
use Filament\PanelProvider as BasePanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Venture\Blueprint\Concerns\InteractsWithModule;
use Venture\Home\Actions\MakePanel;

class PanelProvider extends BasePanelProvider
{
    use InteractsWithModule;

    public function panel(Panel $panel): Panel
    {
        $name = $this->getModuleName();
        $slug = $this->getModuleSlug();

        return MakePanel::run($panel, $name, $slug)
            ->colors([
                'primary' => Color::Blue,
            ])
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ]);
    }
}
