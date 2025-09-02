<?php

namespace Venture\Home\Models\Subscription\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Venture\Home\Models\Subscription;

abstract class SubscriptionEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public Subscription $subscription;

    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }
}
