<?php

namespace Venture\Home\Providers;

use Filament\Panel;
use Filament\PanelProvider as BasePanelProvider;
use Filament\Support\Colors\Color;
use Venture\Alpha\Actions\MakePanel;
use Venture\Home\Concerns\InteractsWithModule;

class PanelProvider extends BasePanelProvider
{
    use InteractsWithModule;

    public function panel(Panel $panel): Panel
    {
        $name = $this->getModuleName();
        $slug = $this->getModuleSlug();

        return MakePanel::run($panel, $name, $slug)
            ->colors([
                'primary' => Color::Amber,
            ]);
    }
}
