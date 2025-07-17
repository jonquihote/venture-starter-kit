<?php

namespace Venture\Home\Enums;

enum MigrationsEnum
{
    case USERS;
    case USER_CREDENTIALS;
    case TEMPORARY_FILES;

    public function table(): string
    {
        return match ($this) {
            self::USERS => 'home_users',
            self::USER_CREDENTIALS => 'home_user_credentials',
            self::TEMPORARY_FILES => 'home_temporary_files',
        };
    }
}
