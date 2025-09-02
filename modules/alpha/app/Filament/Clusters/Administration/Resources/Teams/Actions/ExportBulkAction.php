<?php

namespace Venture\Alpha\Filament\Clusters\Administration\Resources\Teams\Actions;

use Filament\Actions\ExportBulkAction as BaseExportBulkAction;
use Venture\Alpha\Filament\Exports\TeamExporter;
use Venture\Alpha\Models\Team;

class ExportBulkAction extends BaseExportBulkAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('alpha::filament/resources/team/actions/bulk-export.label'));

        $this->modalHeading(__('alpha::filament/resources/team/actions/bulk-export.modal.heading'));

        $this->modalSubmitActionLabel(__('alpha::filament/resources/team/actions/bulk-export.modal.actions.submit.label'));

        $this->tableIcon('lucide-file-down');
        $this->groupedIcon('lucide-file-down');

        $this->deselectRecordsAfterCompletion();

        $this->exporter(TeamExporter::class);

        $this->authorize('customExport', Team::class);
    }
}
