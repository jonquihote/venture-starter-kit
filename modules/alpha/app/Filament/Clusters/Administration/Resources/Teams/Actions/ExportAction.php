<?php

namespace Venture\Alpha\Filament\Clusters\Administration\Resources\Teams\Actions;

use Filament\Actions\ExportAction as BaseExportAction;
use Venture\Alpha\Filament\Exports\TeamExporter;
use Venture\Alpha\Models\Team;

class ExportAction extends BaseExportAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('alpha::filament/resources/team/actions/export.label'));

        $this->modalHeading(__('alpha::filament/resources/team/actions/export.modal.heading'));

        $this->modalSubmitActionLabel(__('alpha::filament/resources/team/actions/export.modal.actions.submit.label'));

        $this->tableIcon('lucide-file-down');
        $this->groupedIcon('lucide-file-down');

        $this->exporter(TeamExporter::class);

        $this->authorize('customExport', Team::class);
    }
}
