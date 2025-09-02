<?php

namespace Venture\Alpha\Models\Account\Concerns;

use Spatie\Activitylog\LogOptions;
use Venture\Aeon\Packages\Spatie\Activitylog\Models\Activity;

trait ConfigureActivityLog
{
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name'])
            ->logOnlyDirty()
            ->useLogName('eloquent')
            ->dontSubmitEmptyLogs();
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->description = $eventName;
    }
}
