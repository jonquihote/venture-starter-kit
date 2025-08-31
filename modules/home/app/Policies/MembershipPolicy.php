<?php

namespace Venture\Home\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Venture\Home\Enums\Auth\Permissions\MembershipPermissionsEnum;
use Venture\Home\Models\Account;
use Venture\Home\Models\Membership;

class MembershipPolicy
{
    use HandlesAuthorization;

    public function viewAny(Account $account): bool
    {
        return $account->can(MembershipPermissionsEnum::ViewAny);
    }

    public function view(Account $account, Membership $membership): bool
    {
        return $account->can(MembershipPermissionsEnum::View);
    }

    public function create(Account $account): bool
    {
        return $account->can(MembershipPermissionsEnum::Create);
    }

    public function update(Account $account, Membership $membership): bool
    {
        return $account->can(MembershipPermissionsEnum::Update);
    }

    public function delete(Account $account, Membership $membership): bool
    {
        return $account->can(MembershipPermissionsEnum::Delete);
    }

    public function restore(Account $account, Membership $membership): bool
    {
        return $account->can(MembershipPermissionsEnum::Restore);
    }

    public function forceDelete(Account $account, Membership $membership): bool
    {
        return $account->can(MembershipPermissionsEnum::ForceDelete);
    }

    public function reorder(Account $account): bool
    {
        return $account->can(MembershipPermissionsEnum::Reorder);
    }

    public function deleteAny(Account $account): bool
    {
        return $account->can(MembershipPermissionsEnum::DeleteAny);
    }

    public function restoreAny(Account $account): bool
    {
        return $account->can(MembershipPermissionsEnum::RestoreAny);
    }

    public function forceDeleteAny(Account $account): bool
    {
        return $account->can(MembershipPermissionsEnum::ForceDeleteAny);
    }
}
