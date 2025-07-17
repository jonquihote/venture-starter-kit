<?php

namespace Venture\Home\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use Venture\Home\Enums\Auth\Permissions\UserResourcePermissionsEnum;
use Venture\Home\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can(UserResourcePermissionsEnum::VIEW_ANY);
    }

    public function view(User $user, User $model): bool
    {
        return $user->can(UserResourcePermissionsEnum::VIEW);
    }

    public function create(User $user): bool
    {
        return $user->can(UserResourcePermissionsEnum::CREATE);
    }

    public function update(User $user, User $model): bool
    {
        return $user->can(UserResourcePermissionsEnum::UPDATE);
    }

    public function deleteAny(User $user): bool
    {
        return $user->can(UserResourcePermissionsEnum::DELETE_ANY);
    }

    public function delete(User $user, User $model): bool
    {
        return $user->can(UserResourcePermissionsEnum::DELETE) && ! Auth::user()->is($model);
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can(UserResourcePermissionsEnum::FORCE_DELETE_ANY);
    }

    public function forceDelete(User $user, User $model): bool
    {
        return $user->can(UserResourcePermissionsEnum::FORCE_DELETE);
    }

    public function restore(User $user, User $model): bool
    {
        return $user->can(UserResourcePermissionsEnum::RESTORE);
    }

    public function reorder(User $user): bool
    {
        return $user->can(UserResourcePermissionsEnum::REORDER);
    }
}
