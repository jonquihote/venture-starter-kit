<?php

namespace Venture\Home\Filament\Clusters\Settings;

use BackedEnum;
use Filament\Clusters\Cluster;

class SettingsCluster extends Cluster
{
    protected static string | BackedEnum | null $navigationIcon = 'lucide-settings';

    protected static ?int $navigationSort = 300;

    public static function getNavigationLabel(): string
    {
        return __('home::filament/clusters/settings.navigation.label');
    }
}
