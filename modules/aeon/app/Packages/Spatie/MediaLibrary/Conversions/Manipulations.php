<?php

namespace Venture\Aeon\Packages\Spatie\MediaLibrary\Conversions;

use Illuminate\Support\Str;
use Spatie\Image\Drivers\ImageDriver;
use Spatie\MediaLibrary\Conversions\Manipulations as BaseManipulations;

class Manipulations extends BaseManipulations
{
    public function addManipulation(string $name, array $parameters = []): BaseManipulations
    {
        $this->manipulations[Str::random()] = [
            'operation' => $name,
            'parameters' => $parameters,
        ];

        return $this;
    }

    public function apply(ImageDriver $image): void
    {
        foreach ($this->manipulations as $manipulation) {
            $operation = $manipulation['operation'];
            $parameters = $this->transformParameters($operation, $manipulation['parameters']);

            $image->$operation(...$parameters);
        }
    }
}
