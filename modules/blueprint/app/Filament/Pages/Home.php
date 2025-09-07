<?php

namespace Venture\Blueprint\Filament\Pages;

use Filament\Pages\Page;
use Venture\Blueprint\Models\Post;

class Home extends Page
{
    protected string $view = 'blueprint::filament.pages.home';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $title = '';

    public Post $post;

    public function mount(): void
    {
        $this->post = Post::query()
            ->where('is_home_page', true)
            ->first();
    }

    public static function getNavigationLabel(): string
    {
        return __('blueprint::filament/pages/home.navigation.label');
    }
}
