<?php

namespace Venture\Home\Enums;

enum MigrationsEnum
{
    case Attachments;
    case Accounts;
    case AccountCredentials;
    case Teams;
    case Memberships;
    case Applications;
    case Subscriptions;

    public function table(): string
    {
        return match ($this) {
            self::Attachments => 'home_attachments',
            self::Accounts => 'home_accounts',
            self::AccountCredentials => 'home_account_credentials',
            self::Teams => 'home_teams',
            self::Memberships => 'home_memberships',
            self::Applications => 'home_applications',
            self::Subscriptions => 'home_subscriptions',
        };
    }
}
