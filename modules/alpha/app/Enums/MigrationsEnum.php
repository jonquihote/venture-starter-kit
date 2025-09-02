<?php

namespace Venture\Alpha\Enums;

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
            self::Attachments => 'alpha_attachments',
            self::Accounts => 'alpha_accounts',
            self::AccountCredentials => 'alpha_account_credentials',
            self::Teams => 'alpha_teams',
            self::Memberships => 'alpha_memberships',
            self::Applications => 'alpha_applications',
            self::Subscriptions => 'alpha_subscriptions',
        };
    }
}
