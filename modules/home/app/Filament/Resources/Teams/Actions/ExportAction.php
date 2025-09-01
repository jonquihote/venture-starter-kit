<?php

namespace Venture\Home\Filament\Resources\Teams\Actions;

use Filament\Actions\ExportAction as BaseExportAction;
use Venture\Home\Filament\Exports\TeamExporter;
use Venture\Home\Models\Team;

class ExportAction extends BaseExportAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('home::filament/resources/team/actions/export.label'));

        $this->modalHeading(__('home::filament/resources/team/actions/export.modal.heading'));

        $this->modalSubmitActionLabel(__('home::filament/resources/team/actions/export.modal.actions.submit.label'));

        $this->tableIcon('lucide-file-down');
        $this->groupedIcon('lucide-file-down');

        $this->exporter(TeamExporter::class);

        $this->authorize('customExport', Team::class);
    }
}
