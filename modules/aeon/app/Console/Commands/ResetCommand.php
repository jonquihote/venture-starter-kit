<?php

namespace Venture\Aeon\Console\Commands;

use Illuminate\Console\Command;

class ResetCommand extends Command
{
    protected $signature = 'reset';

    protected $description = 'Reset application to its original state';

    public function handle(): int
    {
        $this->call('migrate:fresh');
        $this->call('bootstrap');
        $this->call('db:seed');

        return self::SUCCESS;
    }
}
