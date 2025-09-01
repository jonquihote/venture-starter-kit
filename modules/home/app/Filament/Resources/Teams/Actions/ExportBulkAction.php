<?php

namespace Venture\Home\Filament\Resources\Teams\Actions;

use Filament\Actions\ExportBulkAction as BaseExportBulkAction;
use Venture\Home\Filament\Exports\TeamExporter;
use Venture\Home\Models\Team;

class ExportBulkAction extends BaseExportBulkAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('home::filament/resources/team/actions/bulk-export.label'));

        $this->modalHeading(__('home::filament/resources/team/actions/bulk-export.modal.heading'));

        $this->modalSubmitActionLabel(__('home::filament/resources/team/actions/bulk-export.modal.actions.submit.label'));

        $this->tableIcon('lucide-file-down');
        $this->groupedIcon('lucide-file-down');

        $this->deselectRecordsAfterCompletion();

        $this->exporter(TeamExporter::class);

        $this->authorize('customExport', Team::class);
    }
}
