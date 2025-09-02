<?php

namespace Venture\Alpha\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Venture\Alpha\Enums\Auth\Permissions\TeamPermissionsEnum;
use Venture\Alpha\Models\Account;
use Venture\Alpha\Models\Team;

class TeamPolicy
{
    use HandlesAuthorization;

    public function viewAny(Account $account): bool
    {
        return $account->can(TeamPermissionsEnum::ViewAny);
    }

    public function view(Account $account, Team $team): bool
    {
        return $account->can(TeamPermissionsEnum::View);
    }

    public function create(Account $account): bool
    {
        return $account->can(TeamPermissionsEnum::Create);
    }

    public function update(Account $account, Team $team): bool
    {
        return $account->can(TeamPermissionsEnum::Update);
    }

    public function delete(Account $account, Team $team): bool
    {
        return $account->can(TeamPermissionsEnum::Delete);
    }

    public function restore(Account $account, Team $team): bool
    {
        return $account->can(TeamPermissionsEnum::Restore);
    }

    public function forceDelete(Account $account, Team $team): bool
    {
        return $account->can(TeamPermissionsEnum::ForceDelete);
    }

    public function reorder(Account $account): bool
    {
        return $account->can(TeamPermissionsEnum::Reorder);
    }

    public function deleteAny(Account $account): bool
    {
        return $account->can(TeamPermissionsEnum::DeleteAny);
    }

    public function restoreAny(Account $account): bool
    {
        return $account->can(TeamPermissionsEnum::RestoreAny);
    }

    public function forceDeleteAny(Account $account): bool
    {
        return $account->can(TeamPermissionsEnum::ForceDeleteAny);
    }
}
