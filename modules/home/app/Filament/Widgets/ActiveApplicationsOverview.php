<?php

namespace Venture\Home\Filament\Widgets;

use Filament\Widgets\Widget;
use Venture\Aeon\Facades\Access;

class ActiveApplicationsOverview extends Widget
{
    protected int | string | array $columnSpan = 'full';

    protected string $view = 'home::filament.widgets.active-applications-overview';

    protected function getViewData(): array
    {
        return [
            'applications' => Access::applications(),
        ];
    }
}
