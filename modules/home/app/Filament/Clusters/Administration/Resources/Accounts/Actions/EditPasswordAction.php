<?php

namespace Venture\Home\Filament\Clusters\Administration\Resources\Accounts\Actions;

use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Venture\Home\Filament\Clusters\Administration\Resources\Accounts\Schemas\EditPasswordForm;
use Venture\Home\Models\Account;

class EditPasswordAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'edit-password';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('home::filament/resources/account/actions/edit-password.label'));

        $this->modalHeading(__('home::filament/resources/account/actions/edit-password.modal.heading'));

        $this->modalSubmitActionLabel(__('home::filament/resources/account/actions/edit-password.modal.actions.submit.label'));

        $this->modalWidth(Width::Small);

        $this->successNotificationTitle(__('home::filament/resources/account/actions/edit-password.notifications.success.title'));

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
