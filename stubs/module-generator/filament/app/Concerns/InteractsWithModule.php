<?php

namespace Venture\{Module}\Concerns;

trait InteractsWithModule
{
    public function getModuleName(): string
    {
        return '{Module}';
    }

    public function getModuleSlug(): string
    {
        return '{module}';
    }

    public function getModuleIcon(): string
    {
        return 'lucide-app-window';
    }
}
