<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as Trail;
use Filament\Facades\Filament;
use Venture\Nexus\Filament\Pages\Dashboard;

$panel = Filament::getPanel('nexus');

Breadcrumbs::for(Dashboard::getRouteName($panel), function (Trail $trail): void {
    $trail->push(Dashboard::getNavigationLabel(), Dashboard::getUrl(panel: 'nexus'));
});
