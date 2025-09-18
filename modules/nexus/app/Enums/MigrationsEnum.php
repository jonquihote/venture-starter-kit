<?php

namespace Venture\Nexus\Enums;

enum MigrationsEnum
{
    case Users;

    public function table(): string
    {
        return match ($this) {
            self::Users => 'nexus_users',
        };
    }
}
