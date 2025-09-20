<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as Trail;
use Filament\Facades\Filament;
use Venture\Blueprint\Filament\Pages\Dashboard;
use Venture\Blueprint\Filament\Pages\ShowPost;
use Venture\Blueprint\Models\Post;

$panel = Filament::getPanel('blueprint');

Breadcrumbs::for(Dashboard::getRouteName($panel), function (Trail $trail): void {
    $trail->push(Dashboard::getNavigationLabel(), Dashboard::getUrl(panel: 'blueprint'));
});

Breadcrumbs::for(ShowPost::getRouteName($panel), function (Trail $trail, array $parameters) use ($panel): void {
    $trail->parent(Dashboard::getRouteName($panel));

    $post = $parameters[0];

    if ($post->is_home_page) {
        $trail->push($post->title, ShowPost::getUrl([$post]));
    } else {
        $home = Post::query()
            ->where('is_home_page', true)
            ->first();

        $trail->push($home->title, ShowPost::getUrl([$home]));
        $trail->push($post->title, ShowPost::getUrl([$post]));
    }

});
