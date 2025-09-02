<?php

namespace Venture\Aeon\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ResetApplicationCommand extends Command
{
    protected $signature = 'aeon:reset-application';

    protected $aliases = ['reset'];

    protected $description = 'Reset application to its pristine state';

    public function handle(): int
    {
        File::deleteDirectories(storage_path('app/public'));

        $this->call('migrate:fresh');
        $this->call('aeon:init:engine');
        $this->call('home:init:engine');
        $this->call('db:seed');

        return self::SUCCESS;
    }
}
