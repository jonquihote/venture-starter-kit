<?php

namespace Venture\Alpha\Filament\Clusters\Administration\Resources\Teams\Actions;

use Filament\Actions\ImportAction as BaseImportAction;
use Venture\Alpha\Filament\Imports\TeamImporter;
use Venture\Alpha\Models\Team;

class ImportAction extends BaseImportAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('alpha::filament/resources/team/actions/import.label'));

        $this->modalHeading(__('alpha::filament/resources/team/actions/import.modal.heading'));

        $this->modalSubmitActionLabel(__('alpha::filament/resources/team/actions/import.modal.actions.submit.label'));

        $this->tableIcon('lucide-file-up');
        $this->groupedIcon('lucide-file-up');

        $this->importer(TeamImporter::class);

        $this->authorize('customImport', Team::class);
    }
}
