<?php

namespace Venture\Blueprint\Filament\Clusters\Documentation\Resources\Posts\Actions;

use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class ShowAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'show';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('blueprint::filament/resources/posts/actions/show.label'));

        $this->color('gray');

        $this->url(fn (Model $record): string => $record->getUrl());
    }
}
