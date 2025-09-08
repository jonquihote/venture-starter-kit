<?php

namespace Venture\Blueprint\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Collection;
use Venture\Blueprint\Enums\DocumentationGroupsEnum;
use Venture\Blueprint\Models\Post;

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
                $post = Post::query()
                    ->where('is_home_page', true)
                    ->where('documentation_group', $group)
                    ->first();

                if ($post) {
                    return [
                        'name' => $group->value,
                        'slug' => $group->slug(),
                        'icon' => $group->icon(),
                        'color' => $group->color(),
                        'url' => $post->getUrl(),
                    ];
                }

                return false;
            })
            ->filter()
            ->values();
    }
}
