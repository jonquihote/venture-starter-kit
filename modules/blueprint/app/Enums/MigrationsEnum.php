<?php

namespace Venture\Blueprint\Enums;

enum MigrationsEnum
{
    case Users;

    public function table(): string
    {
        return match ($this) {
            self::Users => 'blueprint_users',
        };
    }
}
