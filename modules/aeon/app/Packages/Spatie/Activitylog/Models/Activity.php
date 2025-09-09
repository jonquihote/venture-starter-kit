<?php

namespace Venture\Aeon\Packages\Spatie\Activitylog\Models;

use Spatie\Activitylog\Models\Activity as BaseActivity;

/**
 * @codeCoverageIgnore
 *
 * This file exists to accommodate `spatie_` prefixed database table
 */
class Activity extends BaseActivity
{
    protected $table = 'spatie_activity_log';
}
