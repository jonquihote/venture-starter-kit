<?php

namespace Venture\Aeon\Packages\Spatie\MediaLibrary\Concerns;

use Spatie\MediaLibrary\InteractsWithMedia as BaseInteractsWithMedia;
use Venture\Aeon\Packages\Spatie\MediaLibrary\Conversions\Conversion;

trait InteractsWithMedia
{
    use BaseInteractsWithMedia;

    public function addMediaConversion(string $name): Conversion
    {
        $conversion = Conversion::create($name);

        $this->mediaConversions[] = $conversion;

        return $conversion;
    }
}
