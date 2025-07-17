<?php

namespace Venture\Aeon\Packages\Spatie\MediaLibrary\Conversions;

use Spatie\MediaLibrary\Conversions\Conversion as BaseConversion;

class Conversion extends BaseConversion
{
    public function __construct(string $name)
    {
        parent::__construct($name);

        $this->manipulations = new Manipulations;
    }
}
