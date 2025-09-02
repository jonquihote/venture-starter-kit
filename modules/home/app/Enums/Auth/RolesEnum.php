<?php

namespace Venture\Home\Enums\Auth;

use Illuminate\Support\Collection;
use Venture\Home\Enums\Auth\Permissions\AccountPermissionsEnum;
use Venture\Home\Enums\Auth\Permissions\ApplicationPermissionsEnum;
use Venture\Home\Enums\Auth\Permissions\AttachmentPermissionsEnum;
use Venture\Home\Enums\Auth\Permissions\MembershipPermissionsEnum;
use Venture\Home\Enums\Auth\Permissions\PagePermissionsEnum;
use Venture\Home\Enums\Auth\Permissions\SubscriptionPermissionsEnum;
use Venture\Home\Enums\Auth\Permissions\TeamPermissionsEnum;

enum RolesEnum: string
{
    case Administrator = 'home::authorization/roles.administrator';
    case User = 'home::authorization/roles.user';

    public static function all(): Collection
    {
        return Collection::make(self::cases())
            ->mapWithKeys(function (RolesEnum $role) {
                return [
                    $role->value => $role->permissions(),
                ];
            });
    }

    public function permissions(): Collection
    {
        $permissions = match ($this) {
            self::Administrator => [
                PagePermissionsEnum::all(),

                AttachmentPermissionsEnum::only(
                    AttachmentPermissionsEnum::ViewAny,
                    AttachmentPermissionsEnum::CustomDownload,
                ),

                AccountPermissionsEnum::all(),
                TeamPermissionsEnum::all(),
                MembershipPermissionsEnum::except(
                    MembershipPermissionsEnum::Update,
                ),
                ApplicationPermissionsEnum::only(
                    ApplicationPermissionsEnum::ViewAny,
                ),
                SubscriptionPermissionsEnum::except(
                    SubscriptionPermissionsEnum::Update,
                ),
            ],
            self::User => [
                PagePermissionsEnum::all(),
            ],
        };

        return Collection::make($permissions)->flatten(1);
    }
}
