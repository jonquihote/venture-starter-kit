<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as Trail;
use Filament\Facades\Filament;
use Venture\{Module}\Filament\Pages\Dashboard;

$panel = Filament::getPanel('{module}');

Breadcrumbs::for(Dashboard::getRouteName($panel), function (Trail $trail): void {
    $trail->push(Dashboard::getNavigationLabel(), Dashboard::getUrl(panel: '{module}'));
});
