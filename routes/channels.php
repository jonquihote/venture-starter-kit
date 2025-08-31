<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('Home.Models.Account.{id}', function ($account, $id) {
    return (int) $account->id === (int) $id;
});
