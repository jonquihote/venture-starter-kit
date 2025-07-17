<?php

namespace Venture\Home\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Venture\Home\Enums\Auth\Permissions\TemporaryFileResourcePermissionsEnum;
use Venture\Home\Models\TemporaryFile;
use Venture\Home\Models\User;

class TemporaryFilePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can(TemporaryFileResourcePermissionsEnum::VIEW_ANY);
    }

    public function view(User $user, TemporaryFile $file): bool
    {
        return $user->can(TemporaryFileResourcePermissionsEnum::VIEW);
    }

    public function create(User $user): bool
    {
        return $user->can(TemporaryFileResourcePermissionsEnum::CREATE);
    }

    public function update(User $user, TemporaryFile $file): bool
    {
        return $user->can(TemporaryFileResourcePermissionsEnum::UPDATE);
    }

    public function deleteAny(User $user): bool
    {
        return $user->can(TemporaryFileResourcePermissionsEnum::DELETE_ANY);
    }

    public function delete(User $user, TemporaryFile $file): bool
    {
        return $user->can(TemporaryFileResourcePermissionsEnum::DELETE);
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can(TemporaryFileResourcePermissionsEnum::FORCE_DELETE_ANY);
    }

    public function forceDelete(User $user, TemporaryFile $file): bool
    {
        return $user->can(TemporaryFileResourcePermissionsEnum::FORCE_DELETE);
    }

    public function restore(User $user, TemporaryFile $file): bool
    {
        return $user->can(TemporaryFileResourcePermissionsEnum::RESTORE);
    }

    public function reorder(User $user): bool
    {
        return $user->can(TemporaryFileResourcePermissionsEnum::REORDER);
    }
}
