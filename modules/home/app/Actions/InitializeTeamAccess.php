<?php

namespace Venture\Home\Actions;

use Illuminate\Support\Collection;
use Lorisleiva\Actions\Action;
use Spatie\Permission\Models\Role;
use Venture\Aeon\Facades\Access;
use Venture\Home\Models\Subscription;

class InitializeTeamAccess extends Action
{
    /**
     * Initialize roles for a team and assign permissions.
     */
    public function handle(Subscription $subscription): void
    {
        setPermissionsTeamId($subscription->team_id);

        Access::roles()->each(function (Collection $permissions, string $role) use ($subscription): void {
            $instance = Role::firstOrCreate([
                'name' => $role,
                'team_id' => $subscription->team_id,
            ]);

            $instance->syncPermissions($permissions);
        });
    }
}
