<?php

namespace Venture\Sigma\Enums;

enum MigrationsEnum
{
    case Users;

    public function table(): string
    {
        return match ($this) {
            self::Users => 'sigma_users',
        };
    }
}
