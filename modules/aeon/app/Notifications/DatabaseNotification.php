<?php

namespace Venture\Aeon\Notifications;

use Illuminate\Notifications\DatabaseNotification as BaseDatabaseNotification;

class DatabaseNotification extends BaseDatabaseNotification
{
    protected $table = 'laravel_notifications';
}
