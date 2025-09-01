<?php

namespace Venture\Home\Filament\Resources\Attachments\Actions;

use Filament\Actions\Action;
use Venture\Home\Models\Attachment;

class DownloadAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'download';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('home::filament/resources/attachment/actions/download.label'));

        $this->defaultColor('primary');

        $this->tableIcon('lucide-download');
        $this->groupedIcon('lucide-download');

        $this->url(function (Attachment $record): string {
            return $record->downloadUrl();
        });

        $this->openUrlInNewTab();

        $this->authorize('customDownload', Attachment::class);
    }
}
