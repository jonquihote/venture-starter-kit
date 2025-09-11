<?php

namespace Venture\Blueprint\Filament\Pages;

use Diglactic\Breadcrumbs\Breadcrumbs;
use Filament\Pages\Page;
use Illuminate\Support\Collection;
use Venture\Blueprint\Models\Post;

class ShowPost extends Page
{
    protected string $view = 'blueprint::filament.pages.show-post';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $title = '';

    protected static ?string $slug = 'show-post/{post}';

    public Post $post;

    public ?Post $previousPost = null;

    public ?Post $nextPost = null;

    public Collection $breadcrumbItems;

    public Collection $navigationItems;

    public function mount(Post $post): void
    {
        $this->post = $post;

        $posts = Post::query()
            ->where('documentation_group', $post->documentation_group)
            ->ordered()
            ->get();

        $this->initializeBreadcrumbNavigation();
        $this->initializeDocumentationNavigation($posts);
        $this->initializeSimplePagination($posts);
    }

    protected function initializeBreadcrumbNavigation(): void
    {
        $this->breadcrumbItems = Breadcrumbs::generate(self::getRouteName(), [$this->post])
            ->mapWithKeys(function ($breadcrumb) {
                return [$breadcrumb->url => $breadcrumb->title];
            });
    }

    protected function initializeDocumentationNavigation(Collection $posts): void
    {
        // Separate posts into standalone and grouped
        $standalone = $posts->whereNull('navigation_group')
            ->map(fn ($post) => [
                'type' => 'post',
                'post' => $post,
                'sort' => $post->navigation_sort,
            ]);

        // Group posts by navigation_group and create group items
        $grouped = $posts->whereNotNull('navigation_group')
            ->groupBy('navigation_group')
            ->map(fn ($groupPosts, $groupName) => [
                'type' => 'group',
                'name' => $groupName,
                'posts' => $groupPosts->sortBy('navigation_sort')->values(),
                'sort' => $groupPosts->min('navigation_sort'), // Position at first post's sort
            ]);

        // Merge standalone posts and groups, then sort by navigation_sort
        $this->navigationItems = $standalone
            ->merge($grouped->values())
            ->sortBy('sort')
            ->values();
    }

    protected function initializeSimplePagination(Collection $posts): void
    {
        $currentSort = $this->post->navigation_sort;

        // Find previous post (highest navigation_sort that is less than current)
        $this->previousPost = $posts
            ->where('navigation_sort', '<', $currentSort)
            ->sortByDesc('navigation_sort')
            ->first();

        // Find next post (lowest navigation_sort that is greater than current)
        $this->nextPost = $posts
            ->where('navigation_sort', '>', $currentSort)
            ->sortBy('navigation_sort')
            ->first();
    }
}
