<?php

namespace Venture\Omega\Policies;

use Venture\Alpha\Models\Account;
use Venture\Omega\Enums\Auth\Permissions\InvitationPermissionsEnum;
use Venture\Omega\Models\Invitation;

class InvitationPolicy
{
    public function viewAny(Account $account): bool
    {
        return $account->can(InvitationPermissionsEnum::ViewAny);
    }

    public function view(Account $account, Invitation $invitation): bool
    {
        return $account->can(InvitationPermissionsEnum::View);
    }

    public function create(Account $account): bool
    {
        return $account->can(InvitationPermissionsEnum::Create);
    }

    public function update(Account $account, Invitation $invitation): bool
    {
        return $account->can(InvitationPermissionsEnum::Update);
    }

    public function delete(Account $account, Invitation $invitation): bool
    {
        return $account->can(InvitationPermissionsEnum::Delete);
    }

    public function restore(Account $account, Invitation $invitation): bool
    {
        return $account->can(InvitationPermissionsEnum::Restore);
    }

    public function forceDelete(Account $account, Invitation $invitation): bool
    {
        return $account->can(InvitationPermissionsEnum::ForceDelete);
    }

    public function reorder(Account $account): bool
    {
        return $account->can(InvitationPermissionsEnum::Reorder);
    }

    public function deleteAny(Account $account): bool
    {
        return $account->can(InvitationPermissionsEnum::DeleteAny);
    }

    public function restoreAny(Account $account): bool
    {
        return $account->can(InvitationPermissionsEnum::RestoreAny);
    }

    public function forceDeleteAny(Account $account): bool
    {
        return $account->can(InvitationPermissionsEnum::ForceDeleteAny);
    }
}
