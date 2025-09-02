<?php

namespace Venture\Alpha\Actions;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Action;
use Spatie\Permission\Models\Role;
use Venture\Aeon\Facades\Access;
use Venture\Alpha\Models\Subscription;

class InitializeTeamAccess extends Action
{
    /**
     * Initialize roles for a team and assign permissions.
     */
    public function handle(Subscription $subscription): void
    {
        Access::roles()
            ->filter(function ($_, string $role) use ($subscription) {
                return Str::startsWith($role, $subscription->application->slug);
            })
            ->each(function (Collection $permissions, string $role) use ($subscription): void {
                $instance = Role::firstOrCreate([
                    'name' => $role,
                    'team_id' => $subscription->team_id,
                ]);

                $instance->syncPermissions($permissions);
            });
    }
}
