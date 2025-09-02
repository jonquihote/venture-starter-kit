<?php

namespace Venture\Alpha\Filament\Clusters\Administration\Resources\Accounts\Actions;

use Filament\Actions\ImportAction as BaseImportAction;
use Venture\Alpha\Filament\Imports\AccountImporter;
use Venture\Alpha\Models\Account;

class ImportAction extends BaseImportAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('alpha::filament/resources/account/actions/import.label'));

        $this->modalHeading(__('alpha::filament/resources/account/actions/import.modal.heading'));

        $this->modalSubmitActionLabel(__('alpha::filament/resources/account/actions/import.modal.actions.submit.label'));

        $this->tableIcon('lucide-file-up');
        $this->groupedIcon('lucide-file-up');

        $this->importer(AccountImporter::class);

        $this->authorize('customImport', Account::class);
    }
}
