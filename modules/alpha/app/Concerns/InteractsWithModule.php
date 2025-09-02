<?php

namespace Venture\Alpha\Concerns;

trait InteractsWithModule
{
    public function getModuleName(): string
    {
        return 'Alpha';
    }

    public function getModuleSlug(): string
    {
        return 'alpha';
    }

    public function getModuleIcon(): string
    {
        return 'lucide-app-window';
    }
}
