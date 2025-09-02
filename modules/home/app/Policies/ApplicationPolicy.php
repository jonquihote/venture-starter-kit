<?php

namespace Venture\Home\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Venture\Home\Enums\Auth\Permissions\ApplicationPermissionsEnum;
use Venture\Home\Models\Account;
use Venture\Home\Models\Application;

class ApplicationPolicy
{
    use HandlesAuthorization;

    public function viewAny(Account $account): bool
    {
        return $account->can(ApplicationPermissionsEnum::ViewAny);
    }

    public function view(Account $account, Application $application): bool
    {
        return $account->can(ApplicationPermissionsEnum::View);
    }

    public function create(Account $account): bool
    {
        return $account->can(ApplicationPermissionsEnum::Create);
    }

    public function update(Account $account, Application $application): bool
    {
        return $account->can(ApplicationPermissionsEnum::Update);
    }

    public function delete(Account $account, Application $application): bool
    {
        return $account->can(ApplicationPermissionsEnum::Delete);
    }

    public function restore(Account $account, Application $application): bool
    {
        return $account->can(ApplicationPermissionsEnum::Restore);
    }

    public function forceDelete(Account $account, Application $application): bool
    {
        return $account->can(ApplicationPermissionsEnum::ForceDelete);
    }

    public function reorder(Account $account): bool
    {
        return $account->can(ApplicationPermissionsEnum::Reorder);
    }

    public function deleteAny(Account $account): bool
    {
        return $account->can(ApplicationPermissionsEnum::DeleteAny);
    }

    public function restoreAny(Account $account): bool
    {
        return $account->can(ApplicationPermissionsEnum::RestoreAny);
    }

    public function forceDeleteAny(Account $account): bool
    {
        return $account->can(ApplicationPermissionsEnum::ForceDeleteAny);
    }
}
