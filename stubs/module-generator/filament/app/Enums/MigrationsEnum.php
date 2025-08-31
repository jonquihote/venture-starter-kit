<?php

namespace Venture\{Module}\Enums;

enum MigrationsEnum
{
    case Users;

    public function table(): string
    {
        return match ($this) {
            self::Users => '{module}_users',
        };
    }
}
