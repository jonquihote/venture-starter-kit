<?php

namespace Venture\Blueprint\Filament\Clusters\Documentation\Resources\Posts\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Venture\Blueprint\Filament\Clusters\Documentation\Resources\Posts\PostResource;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
