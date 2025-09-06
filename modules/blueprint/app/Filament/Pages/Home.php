<?php

namespace Venture\Blueprint\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Venture\Blueprint\Enums\Auth\Permissions\PagePermissionsEnum;
use Venture\Blueprint\Models\Post;

class Home extends Page
{
    protected string $view = 'blueprint::filament.pages.home';

    protected static string | BackedEnum | null $navigationIcon = 'lucide-house';

    protected static ?int $navigationSort = 100;

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

    public function getTitle(): string
    {
        return __('blueprint::filament/pages/home.title');
    }

    public static function canAccess(): bool
    {
        return Auth::user()->can(PagePermissionsEnum::Home);
    }
}
