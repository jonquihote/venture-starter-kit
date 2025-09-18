<?php

namespace Venture\Sigma\Concerns;

trait InteractsWithModule
{
    public function getModuleName(): string
    {
        return 'Sigma';
    }

    public function getModuleSlug(): string
    {
        return 'sigma';
    }

    public function getModuleIcon(): string
    {
        return 'lucide-milestone';
    }
}
