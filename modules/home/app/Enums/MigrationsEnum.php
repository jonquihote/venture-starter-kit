<?php

namespace Venture\Home\Enums;

enum MigrationsEnum
{
    case USERS;
    case USER_CREDENTIALS;

    public function table(): string
    {
        return match ($this) {
            self::USERS => 'home_users',
            self::USER_CREDENTIALS => 'home_user_credentials',
        };
    }
}
