<?php

namespace Venture\Home\Models\Account\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Venture\Home\Models\Account;

abstract class AccountEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public Account $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }
}
