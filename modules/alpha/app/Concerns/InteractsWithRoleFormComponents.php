<?php

namespace Venture\Alpha\Concerns;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Venture\Alpha\Models\Account;

/**
 * @codeCoverageIgnore
 */
trait InteractsWithRoleFormComponents
{
    public static function buildFieldName(string $name, int $teamId): string
    {
        return Str::of($name)
            ->prepend("{$teamId}_")
            ->prepend('roles_input_')
            ->replace('::', '__')
            ->replace('authorization/', 'authorization_')
            ->replace('roles.', 'roles_')
            ->toString();
    }

    public static function buildRoleName(string $name, int $teamId): string
    {
        return Str::of($name)
            ->replace("{$teamId}_", '')
            ->replace('roles_input_', '')
            ->replace('__', '::')
            ->replace('authorization_', 'authorization/')
            ->replace('roles_', 'roles.')
            ->toString();
    }

    public static function syncAccountTeamRoles(Account $account, Collection $roles, int $targetTeamId): void
    {
        $originTeamId = getPermissionsTeamId();

        setPermissionsTeamId($targetTeamId);

        $account->syncRoles($roles->toArray());

        setPermissionsTeamId($originTeamId);
    }
}
