<?php

namespace Venture\Home\Providers;

use Filament\Panel;
use Filament\PanelProvider as BasePanelProvider;
use Filament\Support\Colors\Color;
use Venture\Home\Actions\MakePanel;
use Venture\Home\Concerns\InteractsWithModule;
use Venture\Home\Filament\Pages\Auth\Login;

class PanelProvider extends BasePanelProvider
{
    use InteractsWithModule;

    public function panel(Panel $panel): Panel
    {
        $name = $this->getModuleName();
        $slug = $this->getModuleSlug();

        return MakePanel::run($panel, $name, $slug)
            ->default()
            ->login(Login::class)
            ->colors([
                'primary' => Color::Amber,
            ]);
    }
}
