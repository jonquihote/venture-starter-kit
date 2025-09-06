<?php

namespace Venture\Blueprint\Models\Post\Listeners;

use Illuminate\Events\Dispatcher;
use Venture\Blueprint\Models\Post;
use Venture\Blueprint\Models\Post\Events\PostCreated;
use Venture\Blueprint\Models\Post\Events\PostCreating;
use Venture\Blueprint\Models\Post\Events\PostDeleted;
use Venture\Blueprint\Models\Post\Events\PostDeleting;
use Venture\Blueprint\Models\Post\Events\PostReplicating;
use Venture\Blueprint\Models\Post\Events\PostRetrieved;
use Venture\Blueprint\Models\Post\Events\PostSaved;
use Venture\Blueprint\Models\Post\Events\PostSaving;
use Venture\Blueprint\Models\Post\Events\PostUpdated;
use Venture\Blueprint\Models\Post\Events\PostUpdating;

class PostEventSubscriber
{
    public function handlePostRetrieved(PostRetrieved $event): void
    {
        //
    }

    public function handlePostCreating(PostCreating $event): void
    {
        //
    }

    public function handlePostCreated(PostCreated $event): void
    {
        //
    }

    public function handlePostUpdating(PostUpdating $event): void
    {
        //
    }

    public function handlePostUpdated(PostUpdated $event): void
    {
        //
    }

    public function handlePostSaving(PostSaving $event): void
    {
        // If this post is being set as the home page, unset any other home page
        if ($event->post->is_home_page) {
            Post::where('slug', '!=', $event->post->slug)
                ->where('is_home_page', true)
                ->update(['is_home_page' => false]);
        }
    }

    public function handlePostSaved(PostSaved $event): void
    {
        //
    }

    public function handlePostDeleting(PostDeleting $event): void
    {
        //
    }

    public function handlePostDeleted(PostDeleted $event): void
    {
        //
    }

    public function handlePostReplicating(PostReplicating $event): void
    {
        //
    }

    public function subscribe(Dispatcher $events): array
    {
        return [
            PostRetrieved::class => 'handlePostRetrieved',
            PostCreating::class => 'handlePostCreating',
            PostCreated::class => 'handlePostCreated',
            PostUpdating::class => 'handlePostUpdating',
            PostUpdated::class => 'handlePostUpdated',
            PostSaving::class => 'handlePostSaving',
            PostSaved::class => 'handlePostSaved',
            PostDeleting::class => 'handlePostDeleting',
            PostDeleted::class => 'handlePostDeleted',
            PostReplicating::class => 'handlePostReplicating',
        ];
    }
}
