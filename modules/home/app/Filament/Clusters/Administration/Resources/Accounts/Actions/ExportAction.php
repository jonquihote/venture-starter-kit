<?php

namespace Venture\Home\Filament\Clusters\Administration\Resources\Accounts\Actions;

use Filament\Actions\ExportAction as BaseExportAction;
use Venture\Home\Filament\Exports\AccountExporter;
use Venture\Home\Models\Account;

class ExportAction extends BaseExportAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('home::filament/resources/account/actions/export.label'));

        $this->modalHeading(__('home::filament/resources/account/actions/export.modal.heading'));

        $this->modalSubmitActionLabel(__('home::filament/resources/account/actions/export.modal.actions.submit.label'));

        $this->tableIcon('lucide-file-down');
        $this->groupedIcon('lucide-file-down');

        $this->exporter(AccountExporter::class);

        $this->authorize('customExport', Account::class);
    }
}
