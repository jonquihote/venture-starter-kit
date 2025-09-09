<?php

namespace Venture\Aeon\Packages\Spatie\Tags\Models;

use Spatie\Tags\Tag as BaseTag;

/**
 * @codeCoverageIgnore
 *
 * This file exists to accommodate `spatie_` prefixed database table.
 */
class Tag extends BaseTag
{
    protected $table = 'spatie_tags';
}
