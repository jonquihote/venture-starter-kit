<?php

namespace Venture\Home\Models\Team\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Venture\Home\Models\Team;

abstract class TeamEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public Team $team;

    public function __construct(Team $team)
    {
        $this->team = $team;
    }
}
