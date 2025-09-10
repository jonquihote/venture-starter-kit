<?php

namespace Venture\Alpha\Concerns;

use Filament\Panel;

/**
 * @codeCoverageIgnore
 */
trait InteractsWithFilamentUser
{
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
