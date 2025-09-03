<?php

namespace Venture\Omega\Enums;

enum MigrationsEnum
{
    case Users;

    public function table(): string
    {
        return match ($this) {
            self::Users => 'omega_users',
        };
    }
}
