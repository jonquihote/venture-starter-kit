<?php

namespace Venture\Aeon\Enums;

use Illuminate\Support\Str;
use Stringable;

enum ModulesEnum
{
    case AEON;
    case HOME;

    public function name(): string
    {
        return match ($this) {
            self::AEON => self::AEON->stringable()->title()->toString(),
            self::HOME => self::HOME->stringable()->title()->toString(),
        };
    }

    public function slug(): string
    {
        return match ($this) {
            self::AEON => self::AEON->stringable()->slug()->toString(),
            self::HOME => self::HOME->stringable()->slug()->toString(),
        };
    }

    protected function stringable(): Stringable
    {
        return match ($this) {
            self::AEON => Str::of(self::AEON->name),
            self::HOME => Str::of(self::HOME->name),
        };
    }
}
