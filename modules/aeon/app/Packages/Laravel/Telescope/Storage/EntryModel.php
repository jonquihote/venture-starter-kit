<?php

namespace Venture\Aeon\Packages\Laravel\Telescope\Storage;

use Laravel\Telescope\Storage\EntryModel as BaseEntryModel;

class EntryModel extends BaseEntryModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'laravel_telescope_entries';
}
