<?php

namespace Venture\Home\Models\Application\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Venture\Home\Models\Application;

abstract class ApplicationEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public Application $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }
}
