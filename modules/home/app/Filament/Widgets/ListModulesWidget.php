<?php

namespace Venture\Home\Filament\Widgets;

use Filament\Widgets\Widget;
use Venture\Aeon\Support\Facades\Access;

class ListModulesWidget extends Widget
{
    protected static string $view = 'home::filament.widgets.list-modules-widget';

    protected int|string|array $columnSpan = 2;

    protected function getViewData(): array
    {
        $dashboards = Access::entryPages()
            ->filter(function (array $data, $dashboard) {
                return $dashboard::canAccess();
            })
            ->map(function (array $data) {
                $data['link'] = route($data['route']);

                unset($data['route']);

                return (object) $data;
            });

        return [
            'dashboards' => $dashboards,
        ];
    }
}
