<?php

namespace Venture\Home\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Venture\Home\Enums\Auth\Permissions\AttachmentPermissionsEnum;
use Venture\Home\Models\Account;
use Venture\Home\Models\Attachment;

class AttachmentPolicy
{
    use HandlesAuthorization;

    public function viewAny(Account $account): bool
    {
        return $account->can(AttachmentPermissionsEnum::ViewAny);
    }

    public function view(Account $account, Attachment $attachment): bool
    {
        return $account->can(AttachmentPermissionsEnum::View);
    }

    public function create(Account $account): bool
    {
        return $account->can(AttachmentPermissionsEnum::Create);
    }

    public function update(Account $account, Attachment $attachment): bool
    {
        return $account->can(AttachmentPermissionsEnum::Update);
    }

    public function delete(Account $account, Attachment $attachment): bool
    {
        return $account->can(AttachmentPermissionsEnum::Delete);
    }

    public function restore(Account $account, Attachment $attachment): bool
    {
        return $account->can(AttachmentPermissionsEnum::Restore);
    }

    public function forceDelete(Account $account, Attachment $attachment): bool
    {
        return $account->can(AttachmentPermissionsEnum::ForceDelete);
    }

    public function reorder(Account $account): bool
    {
        return $account->can(AttachmentPermissionsEnum::Reorder);
    }

    public function deleteAny(Account $account): bool
    {
        return $account->can(AttachmentPermissionsEnum::DeleteAny);
    }

    public function restoreAny(Account $account): bool
    {
        return $account->can(AttachmentPermissionsEnum::RestoreAny);
    }

    public function forceDeleteAny(Account $account): bool
    {
        return $account->can(AttachmentPermissionsEnum::ForceDeleteAny);
    }

    public function customDownload(Account $account, Attachment $attachment): bool
    {
        return $account->can(AttachmentPermissionsEnum::CustomDownload);
    }
}
