<?php

namespace Venture\Alpha\Filament\Clusters\Administration\Resources\Accounts\Actions;

use Filament\Actions\ExportBulkAction as BaseExportBulkAction;
use Venture\Alpha\Filament\Exports\AccountExporter;
use Venture\Alpha\Models\Account;

class ExportBulkAction extends BaseExportBulkAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('alpha::filament/resources/account/actions/bulk-export.label'));

        $this->modalHeading(__('alpha::filament/resources/account/actions/bulk-export.modal.heading'));

        $this->modalSubmitActionLabel(__('alpha::filament/resources/account/actions/bulk-export.modal.actions.submit.label'));

        $this->tableIcon('lucide-file-down');
        $this->groupedIcon('lucide-file-down');

        $this->deselectRecordsAfterCompletion();

        $this->exporter(AccountExporter::class);

        $this->authorize('customExport', Account::class);
    }
}
