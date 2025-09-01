<?php

namespace Venture\Home\Filament\Clusters\Administration;

use BackedEnum;
use Filament\Clusters\Cluster;

class AdministrationCluster extends Cluster
{
    protected static string | BackedEnum | null $navigationIcon = 'lucide-shield-check';

    protected static ?int $navigationSort = 200;

    public static function getNavigationLabel(): string
    {
        return __('home::filament/clusters/administration.navigation.label');
    }
}
