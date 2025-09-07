<?php

namespace Venture\Blueprint\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Collection;
use Venture\Blueprint\Enums\DocumentationGroupsEnum;

class DocumentationGroupOverview extends Widget
{
    protected int | string | array $columnSpan = 'full';

    protected string $view = 'blueprint::filament.widgets.documentation-group-overview';

    protected function getViewData(): array
    {
        return [
            'groups' => $this->getDocumentationGroups(),
        ];
    }

    protected function getDocumentationGroups(): Collection
    {
        return Collection::make(DocumentationGroupsEnum::cases())
            ->map(function (DocumentationGroupsEnum $group) {
                return [
                    'name' => $group->value,
                    'slug' => $group->slug(),
                    'icon' => $group->icon(),
                    'color' => $group->color(),
                ];
            });
    }
}
