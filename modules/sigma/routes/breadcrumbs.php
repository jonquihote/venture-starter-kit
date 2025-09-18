<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as Trail;
use Filament\Facades\Filament;
use Venture\Sigma\Filament\Pages\Dashboard;

$panel = Filament::getPanel('sigma');

Breadcrumbs::for(Dashboard::getRouteName($panel), function (Trail $trail): void {
    $trail->push(Dashboard::getNavigationLabel(), Dashboard::getUrl(panel: 'sigma'));
});
