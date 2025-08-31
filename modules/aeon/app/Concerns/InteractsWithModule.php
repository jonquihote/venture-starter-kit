<?php

namespace Venture\Aeon\Concerns;

trait InteractsWithModule
{
    public function getModuleName(): string
    {
        return 'Aeon';
    }

    public function getModuleSlug(): string
    {
        return 'aeon';
    }
}
