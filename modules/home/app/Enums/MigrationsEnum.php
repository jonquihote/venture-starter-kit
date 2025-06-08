<?php

namespace Venture\Home\Enums;

enum MigrationsEnum
{
    case USERS;

    public function table(): string
    {
        return match ($this) {
            self::USERS => 'home_users',
        };
    }
}
