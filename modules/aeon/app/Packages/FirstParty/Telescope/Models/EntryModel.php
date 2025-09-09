<?php

namespace Venture\Aeon\Packages\FirstParty\Telescope\Models;

use Laravel\Telescope\Storage\EntryModel as BaseEntryModel;

/**
 * @codeCoverageIgnore
 *
 * This file exists to accommodate `laravel_` prefixed database table
 */
class EntryModel extends BaseEntryModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'laravel_telescope_entries';
}
