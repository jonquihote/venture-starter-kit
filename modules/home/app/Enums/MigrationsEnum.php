<?php

namespace Venture\Home\Enums;

enum MigrationsEnum
{
    case Attachments;
    case Accounts;
    case AccountCredentials;
    case Teams;
    case Memberships;
    case Engines;
    case Subscriptions;

    public function table(): string
    {
        return match ($this) {
            self::Attachments => 'home_attachments',
            self::Accounts => 'home_accounts',
            self::AccountCredentials => 'home_account_credentials',
            self::Teams => 'home_teams',
            self::Memberships => 'home_memberships',
            self::Engines => 'home_engines',
            self::Subscriptions => 'home_subscriptions',
        };
    }
}
