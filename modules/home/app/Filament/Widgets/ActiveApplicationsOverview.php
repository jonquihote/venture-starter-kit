<?php

namespace Venture\Home\Filament\Widgets;

use Filament\Facades\Filament;
use Filament\Widgets\Widget;
use Illuminate\Support\Collection;
use Venture\Alpha\Models\Application;

class ActiveApplicationsOverview extends Widget
{
    protected int | string | array $columnSpan = 'full';

    protected static bool $isLazy = false;

    protected string $view = 'home::filament.widgets.active-applications-overview';

    protected function getViewData(): array
    {
        return [
            'applications' => $this->getActiveApplications(),
        ];
    }

    protected function getActiveApplications(): Collection
    {
        return Filament::getTenant()
            ->subscriptions
            ->map
            ->application
            ->filter(function (Application $application) {
                $page = $application->page;

                return $page::canAccess();
            })
            ->sortBy('name');
    }
}
