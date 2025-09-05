<?php

namespace Venture\Alpha\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Collection;
use Venture\Alpha\Enums\Auth\Permissions\PagePermissionsEnum;

class QuickLinksWidget extends Widget
{
    protected string $view = 'alpha::filament.widgets.quick-links-widget';

    public static function canView(): bool
    {
        $account = filament()->auth()->user();

        return $account && (
            $account->can(PagePermissionsEnum::HorizonDashboard) ||
            $account->can(PagePermissionsEnum::PulseDashboard) ||
            $account->can(PagePermissionsEnum::TelescopeDashboard)
        );
    }

    protected function getViewData(): array
    {
        return [
            'links' => $this->getAvailableLinks(),
        ];
    }

    protected function getAvailableLinks(): Collection
    {
        $account = filament()->auth()->user();

        $links = Collection::make();

        if ($account->can(PagePermissionsEnum::HorizonDashboard)) {
            $links->push([
                'name' => 'Horizon',
                'url' => url('/horizon'),
                'color' => 'warning',
            ]);
        }

        if ($account->can(PagePermissionsEnum::PulseDashboard)) {
            $links->push([
                'name' => 'Pulse',
                'url' => url('/pulse'),
                'color' => 'success',
            ]);
        }

        if ($account->can(PagePermissionsEnum::TelescopeDashboard)) {
            $links->push([
                'name' => 'Telescope',
                'url' => url('/telescope'),
                'color' => 'info',
            ]);
        }

        return $links;
    }
}
