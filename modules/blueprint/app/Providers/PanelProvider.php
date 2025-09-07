<?php

namespace Venture\Blueprint\Providers;

use Filament\Panel;
use Filament\PanelProvider as BasePanelProvider;
use Filament\Support\Colors\Color;
use Venture\Alpha\Actions\MakePanel;
use Venture\Blueprint\Concerns\InteractsWithModule;
use Venture\Blueprint\Filament\Widgets\DocumentationGroupOverview;

class PanelProvider extends BasePanelProvider
{
    use InteractsWithModule;

    public function panel(Panel $panel): Panel
    {
        $name = $this->getModuleName();
        $slug = $this->getModuleSlug();

        return MakePanel::run($panel, $name, $slug)
            ->colors([
                'primary' => Color::Lime,
            ])
            ->widgets([
                DocumentationGroupOverview::class,
            ]);
    }
}
