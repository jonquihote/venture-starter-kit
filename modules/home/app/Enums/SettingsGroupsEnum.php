<?php

namespace Venture\Home\Enums;

enum SettingsGroupsEnum
{
    case Tenancy;

    public function scope(): string
    {
        return match ($this) {
            self::Tenancy => 'home::tenancy',
        };
    }
}
