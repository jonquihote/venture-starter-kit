<?php

namespace Venture\Blueprint\Filament\Clusters\Documentation\Resources\Posts\Pages;

use Filament\Resources\Pages\CreateRecord;
use Venture\Blueprint\Filament\Clusters\Documentation\Resources\Posts\PostResource;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;
}
