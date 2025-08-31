<?php

namespace Venture\Aeon\Concerns\Notifications;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\HasDatabaseNotifications as BaseHasDatabaseNotifications;
use Venture\Aeon\Models\DatabaseNotification;

trait HasDatabaseNotifications
{
    use BaseHasDatabaseNotifications;

    /**
     * Get the entity's notifications.
     *
     * @return MorphMany<DatabaseNotification, $this>
     */
    public function notifications(): MorphMany
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')->latest();
    }
}
