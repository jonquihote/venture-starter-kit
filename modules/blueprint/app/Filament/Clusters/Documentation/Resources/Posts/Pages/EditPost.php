<?php

namespace Venture\Blueprint\Filament\Clusters\Documentation\Resources\Posts\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Venture\Blueprint\Filament\Clusters\Documentation\Resources\Posts\Actions\ShowAction;
use Venture\Blueprint\Filament\Clusters\Documentation\Resources\Posts\PostResource;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ShowAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): ?string
    {
        return $this->getResourceUrl('edit', ['record' => $this->getRecord()]);
    }
}
