<?php

use Illuminate\Support\Facades\Broadcast;
use Venture\Alpha\Models\Account;

Broadcast::channel('Venture.Alpha.Models.Account.{id}', function (Account $account, int $id) {
    return $account->getKey() === $id;
});
