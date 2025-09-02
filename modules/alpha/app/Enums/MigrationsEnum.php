<?php

namespace Venture\Alpha\Enums;

enum MigrationsEnum
{
    case Users;

    public function table(): string
    {
        return match ($this) {
            self::Users => 'alpha_users',
        };
    }
}
