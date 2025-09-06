<?php

namespace Venture\Blueprint\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Venture\Alpha\Models\Account;
use Venture\Blueprint\Enums\Auth\Permissions\PostPermissionsEnum;
use Venture\Blueprint\Models\Post;

class PostPolicy
{
    use HandlesAuthorization;

    public function viewAny(Account $account): bool
    {
        return $account->can(PostPermissionsEnum::ViewAny);
    }

    public function view(Account $account, Post $post): bool
    {
        return $account->can(PostPermissionsEnum::View);
    }

    public function create(Account $account): bool
    {
        return $account->can(PostPermissionsEnum::Create);
    }

    public function update(Account $account, Post $post): bool
    {
        return $account->can(PostPermissionsEnum::Update);
    }

    public function delete(Account $account, Post $post): bool
    {
        return $account->can(PostPermissionsEnum::Delete);
    }

    public function restore(Account $account, Post $post): bool
    {
        return $account->can(PostPermissionsEnum::Restore);
    }

    public function forceDelete(Account $account, Post $post): bool
    {
        return $account->can(PostPermissionsEnum::ForceDelete);
    }

    public function reorder(Account $account): bool
    {
        return $account->can(PostPermissionsEnum::Reorder);
    }

    public function deleteAny(Account $account): bool
    {
        return $account->can(PostPermissionsEnum::DeleteAny);
    }

    public function restoreAny(Account $account): bool
    {
        return $account->can(PostPermissionsEnum::RestoreAny);
    }

    public function forceDeleteAny(Account $account): bool
    {
        return $account->can(PostPermissionsEnum::ForceDeleteAny);
    }
}
