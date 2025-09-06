<?php

namespace Venture\Blueprint\Models\Post\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Venture\Blueprint\Models\Post;

abstract class PostEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }
}
