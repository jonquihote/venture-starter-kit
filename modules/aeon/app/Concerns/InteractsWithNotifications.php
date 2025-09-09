<?php

namespace Venture\Aeon\Concerns;

use Venture\Aeon\Concerns\Notifications\HasDatabaseNotifications;
use Venture\Aeon\Concerns\Notifications\RoutesNotifications;

/**
 * @codeCoverageIgnore
 *
 * This file has only been modified to accommodate `laravel_` prefix in the database table that handles notifications.
 */
trait InteractsWithNotifications
{
    use HasDatabaseNotifications;
    use RoutesNotifications;
}
