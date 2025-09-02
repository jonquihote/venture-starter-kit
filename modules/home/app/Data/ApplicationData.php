<?php

namespace Venture\Home\Data;

use Spatie\LaravelData\Data;

class ApplicationData extends Data
{
    public function __construct(
        public string $name,
        public string $page,
        public string $icon,
        public bool $is_subscribed_by_default,
    ) {}
}
