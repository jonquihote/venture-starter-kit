<?php

namespace Venture\Aeon\Console\Commands;

use Illuminate\Console\Command;

class SyncIconsCommand extends Command
{
    protected $signature = 'aeon:icons:sync';

    protected $description = 'Sync icons';

    public function handle(): int
    {
        $this->call('blade-fontawesome:sync-icons', ['--pro' => true]);
        $this->call('icons:cache');

        return self::SUCCESS;
    }
}
