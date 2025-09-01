<?php

namespace Venture\Home\Enums;

use BackedEnum;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum NavigationGroupsEnum implements HasIcon, HasLabel
{
    case Settings;

    public function getLabel(): string | Htmlable | null
    {
        return match ($this) {
            self::Settings => __('home::filament/navigation/groups.settings'),
        };
    }

    public function getIcon(): string | BackedEnum | null
    {
        return match ($this) {
            self::Settings => 'lucide-settings',
        };
    }
}
