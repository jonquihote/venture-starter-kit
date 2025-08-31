<?php

namespace Venture\Home\Models\Membership\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Venture\Home\Models\Membership;

abstract class MembershipEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public Membership $membership;

    public function __construct(Membership $membership)
    {
        $this->membership = $membership;
    }
}
