<?php

namespace Venture\Alpha\Filament\Clusters\Administration\Resources\Accounts\Actions;

use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Venture\Alpha\Concerns\InteractsWithRoleFormComponents;
use Venture\Alpha\Filament\Clusters\Administration\Resources\Accounts\Schemas\EditRolesForm;
use Venture\Alpha\Models\Account;

class EditRolesAction extends Action
{
    use InteractsWithRoleFormComponents;

    public static function getDefaultName(): ?string
    {
        return 'edit-roles';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('alpha::filament/resources/account/actions/edit-roles.label'));

        $this->modalHeading(__('alpha::filament/resources/account/actions/edit-roles.modal.heading'));

        $this->modalSubmitActionLabel(__('alpha::filament/resources/account/actions/edit-roles.modal.actions.submit.label'));

        $this->modalWidth(Width::TwoExtraLarge);

        $this->successNotificationTitle(__('alpha::filament/resources/account/actions/edit-roles.notifications.success.title'));

        $this->defaultColor('primary');

        $this->tableIcon('lucide-user-cog');
        $this->groupedIcon('lucide-user-cog');

        $this->schema(function (Schema $schema): Schema {
            return EditRolesForm::configure($schema);
        });

        $this->action(function (Account $record, array $data): void {
            $roles = Collection::make($data)
                ->filter(function ($value, $key) {
                    return Str::startsWith($key, 'roles_input_');
                })
                ->filter()
                ->keys()
                ->map(function (string $role) use ($data) {
                    return self::buildRoleName($role, $data['team_id']);
                });

            self::syncAccountTeamRoles($record, $roles, $data['team_id']);
        });

        $this->authorize('customEditRoles', Account::class);
    }
}
