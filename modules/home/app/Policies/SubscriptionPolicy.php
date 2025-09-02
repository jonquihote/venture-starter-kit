<?php

namespace Venture\Home\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Venture\Home\Enums\Auth\Permissions\SubscriptionPermissionsEnum;
use Venture\Home\Models\Account;
use Venture\Home\Models\Subscription;

class SubscriptionPolicy
{
    use HandlesAuthorization;

    public function viewAny(Account $account): bool
    {
        return $account->can(SubscriptionPermissionsEnum::ViewAny);
    }

    public function view(Account $account, Subscription $subscription): bool
    {
        return $account->can(SubscriptionPermissionsEnum::View);
    }

    public function create(Account $account): bool
    {
        return $account->can(SubscriptionPermissionsEnum::Create);
    }

    public function update(Account $account, Subscription $subscription): bool
    {
        return $account->can(SubscriptionPermissionsEnum::Update);
    }

    public function delete(Account $account, Subscription $subscription): bool
    {
        return $account->can(SubscriptionPermissionsEnum::Delete);
    }

    public function restore(Account $account, Subscription $subscription): bool
    {
        return $account->can(SubscriptionPermissionsEnum::Restore);
    }

    public function forceDelete(Account $account, Subscription $subscription): bool
    {
        return $account->can(SubscriptionPermissionsEnum::ForceDelete);
    }

    public function reorder(Account $account): bool
    {
        return $account->can(SubscriptionPermissionsEnum::Reorder);
    }

    public function deleteAny(Account $account): bool
    {
        return $account->can(SubscriptionPermissionsEnum::DeleteAny);
    }

    public function restoreAny(Account $account): bool
    {
        return $account->can(SubscriptionPermissionsEnum::RestoreAny);
    }

    public function forceDeleteAny(Account $account): bool
    {
        return $account->can(SubscriptionPermissionsEnum::ForceDeleteAny);
    }
}
