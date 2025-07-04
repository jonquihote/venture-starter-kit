<?php

namespace Venture\Aeon\Console\Commands;

use Illuminate\Console\Command;
use Venture\Aeon\Actions\InitializeAuthorization;

class BootstrapCommand extends Command
{
    protected $signature = 'bootstrap';

    protected $description = 'Bootstrap application';

    public function handle(): int
    {
        InitializeAuthorization::run($this->components);

        return self::SUCCESS;
    }
}
