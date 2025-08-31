<?php

namespace Venture\Home\Filament\Resources\Accounts\Actions;

use Filament\Actions\ImportAction as BaseImportAction;
use Venture\Home\Filament\Imports\AccountImporter;
use Venture\Home\Models\Account;

class ImportAction extends BaseImportAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('home::filament/resources/account/actions/import.label'));

        $this->modalHeading(__('home::filament/resources/account/actions/import.modal.heading'));

        $this->modalSubmitActionLabel(__('home::filament/resources/account/actions/import.modal.actions.submit.label'));

        $this->tableIcon('lucide-file-up');
        $this->groupedIcon('lucide-file-up');

        $this->importer(AccountImporter::class);

        $this->authorize('customImport', Account::class);
    }
}
