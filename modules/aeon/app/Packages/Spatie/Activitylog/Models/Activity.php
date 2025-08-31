<?php

namespace Venture\Aeon\Packages\Spatie\Activitylog\Models;

use Spatie\Activitylog\Models\Activity as BaseActivity;

class Activity extends BaseActivity
{
    protected $table = 'spatie_activity_log';
}
