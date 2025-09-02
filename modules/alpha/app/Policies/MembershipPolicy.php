<?php

namespace Venture\Alpha\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Venture\Alpha\Enums\Auth\Permissions\MembershipPermissionsEnum;
use Venture\Alpha\Models\Account;
use Venture\Alpha\Models\Membership;

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
