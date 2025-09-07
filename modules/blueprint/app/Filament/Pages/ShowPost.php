<?php

namespace Venture\Blueprint\Filament\Pages;

use Filament\Pages\Page;
use Venture\Blueprint\Models\Post;

class ShowPost extends Page
{
    protected string $view = 'blueprint::filament.pages.show-post';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $title = '';

    protected static ?string $slug = 'show-post/{post}';

    public Post $post;

    public function mount(Post $post): void
    {
        $this->post = $post;
    }
}
