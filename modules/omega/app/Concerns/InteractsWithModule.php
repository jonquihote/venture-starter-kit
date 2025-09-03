<?php

namespace Venture\Omega\Concerns;

trait InteractsWithModule
{
    public function getModuleName(): string
    {
        return 'Omega';
    }

    public function getModuleSlug(): string
    {
        return 'omega';
    }

    public function getModuleIcon(): string
    {
        return 'lucide-users';
    }
}
