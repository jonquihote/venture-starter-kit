<?php

namespace Venture\Alpha\Filament\Clusters\Administration\Resources\Accounts\Actions;

use Filament\Actions\ExportAction as BaseExportAction;
use Venture\Alpha\Filament\Exports\AccountExporter;
use Venture\Alpha\Models\Account;

class ExportAction extends BaseExportAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('alpha::filament/resources/account/actions/export.label'));

        $this->modalHeading(__('alpha::filament/resources/account/actions/export.modal.heading'));

        $this->modalSubmitActionLabel(__('alpha::filament/resources/account/actions/export.modal.actions.submit.label'));

        $this->tableIcon('lucide-file-down');
        $this->groupedIcon('lucide-file-down');

        $this->exporter(AccountExporter::class);

        $this->authorize('customExport', Account::class);
    }
}
