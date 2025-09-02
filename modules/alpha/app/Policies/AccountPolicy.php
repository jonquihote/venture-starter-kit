<?php

namespace Venture\Alpha\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Venture\Alpha\Enums\Auth\Permissions\AccountPermissionsEnum;
use Venture\Alpha\Models\Account;

class AccountPolicy
{
    use HandlesAuthorization;

    public function viewAny(Account $account): bool
    {
        return $account->can(AccountPermissionsEnum::ViewAny);
    }

    public function view(Account $account, Account $model): bool
    {
        return $account->can(AccountPermissionsEnum::View);
    }

    public function create(Account $account): bool
    {
        return $account->can(AccountPermissionsEnum::Create);
    }

    public function update(Account $account, Account $model): bool
    {
        return $account->can(AccountPermissionsEnum::Update);
    }

    public function delete(Account $account, Account $model): bool
    {
        return $account->can(AccountPermissionsEnum::Delete);
    }

    public function restore(Account $account, Account $model): bool
    {
        return $account->can(AccountPermissionsEnum::Restore);
    }

    public function forceDelete(Account $account, Account $model): bool
    {
        return $account->can(AccountPermissionsEnum::ForceDelete);
    }

    public function reorder(Account $account): bool
    {
        return $account->can(AccountPermissionsEnum::Reorder);
    }

    public function deleteAny(Account $account): bool
    {
        return $account->can(AccountPermissionsEnum::DeleteAny);
    }

    public function restoreAny(Account $account): bool
    {
        return $account->can(AccountPermissionsEnum::RestoreAny);
    }

    public function forceDeleteAny(Account $account): bool
    {
        return $account->can(AccountPermissionsEnum::ForceDeleteAny);
    }

    public function customExport(Account $account): bool
    {
        return $account->can(AccountPermissionsEnum::CustomExport);
    }

    public function customImport(Account $account): bool
    {
        return $account->can(AccountPermissionsEnum::CustomImport);
    }

    public function customEditRoles(Account $account, Account $model): bool
    {
        return $account->can(AccountPermissionsEnum::CustomEditRoles);
    }

    public function customEditPassword(Account $account, Account $model): bool
    {
        return $account->can(AccountPermissionsEnum::CustomEditPassword);
    }
}
