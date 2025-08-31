<?php

namespace Venture\Home\Enums;

enum MigrationsEnum
{
    case Accounts;
    case AccountCredentials;
    case Teams;
    case Memberships;

    public function table(): string
    {
        return match ($this) {
            self::Accounts => 'home_accounts',
            self::AccountCredentials => 'home_account_credentials',
            self::Teams => 'home_teams',
            self::Memberships => 'home_memberships',
        };
    }
}
