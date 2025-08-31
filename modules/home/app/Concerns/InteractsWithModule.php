<?php

namespace Venture\Home\Concerns;

trait InteractsWithModule
{
    public function getModuleName(): string
    {
        return 'Home';
    }

    public function getModuleSlug(): string
    {
        return 'home';
    }
}
