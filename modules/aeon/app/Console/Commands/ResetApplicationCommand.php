<?php

namespace Venture\Aeon\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Laravel\Pulse\Facades\Pulse;
use Laravel\Telescope\Telescope;

class ResetApplicationCommand extends Command
{
    protected $signature = 'aeon:reset-application';

    protected $aliases = ['reset'];

    protected $description = 'Reset application to its pristine state';

    public function handle(): int
    {
        File::deleteDirectories(storage_path('app/public'));
        File::deleteDirectories(storage_path('app/private'));

        Telescope::stopRecording();
        Pulse::stopRecording();

        $this->call('migrate:fresh');
        $this->call('horizon:forget', ['--all' => true]);
        $this->call('aeon:init:access');
        $this->call('alpha:init:engine');
        $this->call('db:seed');

        return self::SUCCESS;
    }
}
