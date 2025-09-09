<?php

namespace Venture\Aeon\Packages\Spatie\MediaLibrary\MediaCollections\Models;

use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

/**
 * @codeCoverageIgnore
 *
 * This file exists to accommodate `spatie_` prefixed database table.
 */
class Media extends BaseMedia
{
    protected $table = 'spatie_media';
}
