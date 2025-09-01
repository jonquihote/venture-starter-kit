<?php

namespace Venture\Home\Filament\Resources\Teams\Actions;

use Filament\Actions\ImportAction as BaseImportAction;
use Venture\Home\Filament\Imports\TeamImporter;
use Venture\Home\Models\Team;

class ImportAction extends BaseImportAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('home::filament/resources/team/actions/import.label'));

        $this->modalHeading(__('home::filament/resources/team/actions/import.modal.heading'));

        $this->modalSubmitActionLabel(__('home::filament/resources/team/actions/import.modal.actions.submit.label'));

        $this->tableIcon('lucide-file-up');
        $this->groupedIcon('lucide-file-up');

        $this->importer(TeamImporter::class);

        $this->authorize('customImport', Team::class);
    }
}
