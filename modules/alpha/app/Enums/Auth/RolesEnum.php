<?php

namespace Venture\Alpha\Enums\Auth;

use Illuminate\Support\Collection;
use Venture\Alpha\Enums\Auth\Permissions\AccountPermissionsEnum;
use Venture\Alpha\Enums\Auth\Permissions\ApplicationPermissionsEnum;
use Venture\Alpha\Enums\Auth\Permissions\AttachmentPermissionsEnum;
use Venture\Alpha\Enums\Auth\Permissions\MembershipPermissionsEnum;
use Venture\Alpha\Enums\Auth\Permissions\PagePermissionsEnum;
use Venture\Alpha\Enums\Auth\Permissions\SubscriptionPermissionsEnum;
use Venture\Alpha\Enums\Auth\Permissions\TeamPermissionsEnum;

enum RolesEnum: string
{
    case SuperAdministrator = 'alpha::authorization/roles.super-administrator';
    case Administrator = 'alpha::authorization/roles.administrator';
    case User = 'alpha::authorization/roles.user';

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
            self::SuperAdministrator => [
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
            self::Administrator => [
                PagePermissionsEnum::only(
                    PagePermissionsEnum::Dashboard,
                ),

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
