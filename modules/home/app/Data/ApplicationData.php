<?php

namespace Venture\Home\Data;

use Spatie\LaravelData\Data;

class ApplicationData extends Data
{
    public function __construct(
        public string $page,
        public string $name,
        public string $slug,
        public string $icon,
    ) {}
}
