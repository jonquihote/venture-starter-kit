<?php

namespace Venture\Alpha\Enums;

enum SettingsGroupsEnum
{
    case Tenancy;

    public function scope(): string
    {
        return match ($this) {
            self::Tenancy => 'alpha::tenancy',
        };
    }
}
