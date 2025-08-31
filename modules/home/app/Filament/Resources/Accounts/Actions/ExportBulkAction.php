<?php

namespace Venture\Home\Filament\Resources\Accounts\Actions;

use Filament\Actions\ExportBulkAction as BaseExportBulkAction;
use Venture\Home\Filament\Exports\AccountExporter;
use Venture\Home\Models\Account;

class ExportBulkAction extends BaseExportBulkAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('home::filament/resources/account/actions/bulk-export.label'));

        $this->modalHeading(__('home::filament/resources/account/actions/bulk-export.modal.heading'));

        $this->modalSubmitActionLabel(__('home::filament/resources/account/actions/bulk-export.modal.actions.submit.label'));

        $this->tableIcon('lucide-file-down');
        $this->groupedIcon('lucide-file-down');

        $this->deselectRecordsAfterCompletion();

        $this->exporter(AccountExporter::class);

        $this->authorize('customExport', Account::class);
    }
}
