<?php

namespace Venture\Alpha\Models\Account\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Venture\Alpha\Models\Account;

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
