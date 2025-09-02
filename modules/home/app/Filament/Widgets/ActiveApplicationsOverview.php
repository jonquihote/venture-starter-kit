<?php

namespace Venture\Home\Filament\Widgets;

use Filament\Facades\Filament;
use Filament\Widgets\Widget;
use Venture\Alpha\Models\Application;

class ActiveApplicationsOverview extends Widget
{
    protected int | string | array $columnSpan = 'full';

    protected string $view = 'home::filament.widgets.active-applications-overview';

    protected function getViewData(): array
    {
        $applications = Filament::getTenant()
            ->subscriptions
            ->map
            ->application
            ->filter(function (Application $application) {
                $page = $application->page;

                return $page::canAccess();
            })
            ->sortBy('name');

        return [
            'applications' => $applications,
        ];
    }
}
