<?php

namespace Venture\Aeon\Concerns;

use Venture\Aeon\Concerns\Notifications\HasDatabaseNotifications;
use Venture\Aeon\Concerns\Notifications\RoutesNotifications;

trait InteractsWithNotifications
{
    use HasDatabaseNotifications;
    use RoutesNotifications;
}
