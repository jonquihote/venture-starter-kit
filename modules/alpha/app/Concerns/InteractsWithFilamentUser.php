<?php

namespace Venture\Alpha\Concerns;

use Filament\Panel;

trait InteractsWithFilamentUser
{
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
