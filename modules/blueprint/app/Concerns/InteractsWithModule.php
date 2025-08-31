<?php

namespace Venture\Blueprint\Concerns;

trait InteractsWithModule
{
    public function getModuleName(): string
    {
        return 'Blueprint';
    }

    public function getModuleSlug(): string
    {
        return 'blueprint';
    }

    public function getModuleIcon(): string
    {
        return 'lucide-notebook';
    }
}
