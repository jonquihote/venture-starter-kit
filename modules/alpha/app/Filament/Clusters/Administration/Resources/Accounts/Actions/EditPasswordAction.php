<?php

namespace Venture\Alpha\Filament\Clusters\Administration\Resources\Accounts\Actions;

use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Venture\Alpha\Filament\Clusters\Administration\Resources\Accounts\Schemas\EditPasswordForm;
use Venture\Alpha\Models\Account;

class EditPasswordAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'edit-password';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('alpha::filament/resources/account/actions/edit-password.label'));

        $this->modalHeading(__('alpha::filament/resources/account/actions/edit-password.modal.heading'));

        $this->modalSubmitActionLabel(__('alpha::filament/resources/account/actions/edit-password.modal.actions.submit.label'));

        $this->modalWidth(Width::Small);

        $this->successNotificationTitle(__('alpha::filament/resources/account/actions/edit-password.notifications.success.title'));

        $this->defaultColor('primary');

        $this->tableIcon('lucide-key-round');
        $this->groupedIcon('lucide-key-round');

        $this->schema(function (Schema $schema): Schema {
            return EditPasswordForm::configure($schema);
        });

        $this->action(function (Account $record, array $data): void {
            $record->update([
                'password' => $data['password'],
            ]);
        });

        $this->authorize('customEditPassword', Account::class);
    }
}
