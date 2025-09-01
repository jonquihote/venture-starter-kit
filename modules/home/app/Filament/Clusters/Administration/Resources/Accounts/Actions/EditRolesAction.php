<?php

namespace Venture\Home\Filament\Clusters\Administration\Resources\Accounts\Actions;

use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Venture\Aeon\Packages\Spatie\Permission\Models\Role;
use Venture\Home\Filament\Clusters\Administration\Resources\Accounts\Schemas\EditRolesForm;
use Venture\Home\Models\Account;

class EditRolesAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'edit-roles';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('home::filament/resources/account/actions/edit-roles.label'));

        $this->modalHeading(__('home::filament/resources/account/actions/edit-roles.modal.heading'));

        $this->modalSubmitActionLabel(__('home::filament/resources/account/actions/edit-roles.modal.actions.submit.label'));

        $this->modalWidth(Width::TwoExtraLarge);

        $this->successNotificationTitle(__('home::filament/resources/account/actions/edit-roles.notifications.success.title'));

        $this->defaultColor('primary');

        $this->tableIcon('lucide-user-cog');
        $this->groupedIcon('lucide-user-cog');

        $this->schema(function (Schema $schema): Schema {
            return EditRolesForm::configure($schema);
        });

        $this->fillForm(function (Account $record): array {
            $roles = $record->roles->pluck('name');

            $data = EditRolesForm::getRoleFieldMappings()
                ->mapWithKeys(function ($role, $field) use ($roles) {
                    return [$field => $roles->contains($role)];
                });

            return ['roles' => $data];
        });

        $this->action(function (Account $record, array $data): void {
            $roles = Collection::make($data['roles'])
                ->filter()
                ->keys()
                ->map(function (string $role) {
                    return Str::of($role)->replace('__', '::')->toString();
                })
                ->filter(function (string $roleName) {
                    // Only include roles that actually exist
                    return Role::where('name', $roleName)->exists();
                })
                ->toArray();

            $record->syncRoles($roles);
        });

        $this->authorize('customEditRoles', Account::class);
    }
}
