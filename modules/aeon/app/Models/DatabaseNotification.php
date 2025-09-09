<?php

namespace Venture\Aeon\Models;

use Illuminate\Notifications\DatabaseNotification as BaseDatabaseNotification;

/**
 * @codeCoverageIgnore
 *
 * This file exists to accommodate `laravel_` prefix in the database table that handles notifications.
 */
class DatabaseNotification extends BaseDatabaseNotification
{
    protected $table = 'laravel_notifications';
}
