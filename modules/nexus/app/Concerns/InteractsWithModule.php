<?php

namespace Venture\Nexus\Concerns;

trait InteractsWithModule
{
    public function getModuleName(): string
    {
        return 'Nexus';
    }

    public function getModuleSlug(): string
    {
        return 'nexus';
    }

    public function getModuleIcon(): string
    {
        return 'lucide-workflow';
    }
}
