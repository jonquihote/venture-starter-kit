<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as Trail;
use Filament\Facades\Filament;
use Venture\Alpha\Filament\Pages\Dashboard;

$panel = Filament::getPanel('alpha');

Breadcrumbs::for(Dashboard::getRouteName($panel), function (Trail $trail): void {
    $trail->push(Dashboard::getNavigationLabel(), Dashboard::getUrl(panel: 'alpha'));
});
