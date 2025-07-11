<?php

namespace Venture\Aeon\Console\Commands;

use Illuminate\Console\Command;
use Venture\Aeon\Auth\Actions\InitializeAuthorization;

class BootstrapCommand extends Command
{
    protected $signature = 'aeon:bootstrap';

    protected $description = 'Bootstrap application';

    public function handle(): int
    {
        InitializeAuthorization::run($this->components);

        return self::SUCCESS;
    }
}
