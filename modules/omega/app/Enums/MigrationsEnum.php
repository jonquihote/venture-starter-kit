<?php

namespace Venture\Omega\Enums;

enum MigrationsEnum
{
    case Invitations;

    public function table(): string
    {
        return match ($this) {
            self::Invitations => 'omega_invitations',
        };
    }
}
