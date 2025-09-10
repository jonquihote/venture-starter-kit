<?php

namespace Venture\Alpha\Actions;

use BackedEnum;
use Lorisleiva\Actions\Action;
use Venture\Aeon\Facades\Access;
use Venture\Alpha\Models\Subscription;

/**
 * @codeCoverageIgnore
 */
class AssignTeamOwnerRole extends Action
{
    public function handle(Subscription $subscription): void
    {
        setPermissionsTeamId($subscription->team_id);

        $role = Access::administratorRoles()
            ->first(function (BackedEnum $name) use ($subscription) {
                return str_starts_with($name->value, $subscription->application->slug);
            });

        $subscription->team->owner->assignRole($role);
    }
}
