<?php

namespace Venture\Aeon\Concerns\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\RoutesNotifications as BaseRoutesNotifications;
use Illuminate\Support\Str;

trait RoutesNotifications
{
    use BaseRoutesNotifications;

    /**
     * Get the notification routing information for the given driver.
     *
     * @param  string  $driver
     * @param  Notification|null  $notification
     * @return mixed
     */
    public function routeNotificationFor($driver, $notification = null)
    {
        if (method_exists($this, $method = 'routeNotificationFor' . Str::studly($driver))) {
            return $this->{$method}($notification);
        }

        return match ($driver) {
            'database' => $this->notifications(),
            'mail' => $this->email->value,
            default => null,
        };
    }
}
