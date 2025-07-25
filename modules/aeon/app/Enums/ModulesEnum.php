<?php

namespace Venture\Aeon\Enums;

use Illuminate\Support\Str;
use Stringable;

enum ModulesEnum
{
    case AEON;
    case HOME;
    case GUIDE;

    public function name(): string
    {
        return match ($this) {
            self::AEON => self::AEON->stringable()->title()->toString(),
            self::HOME => self::HOME->stringable()->title()->toString(),
            self::GUIDE => self::GUIDE->stringable()->title()->toString(),
        };
    }

    public function slug(): string
    {
        return match ($this) {
            self::AEON => self::AEON->stringable()->slug()->toString(),
            self::HOME => self::HOME->stringable()->slug()->toString(),
            self::GUIDE => self::GUIDE->stringable()->slug()->toString(),
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::AEON => 'fad:sharp-block',
            self::HOME => 'fad:sharp-house-chimney',
            self::GUIDE => 'fad:sharp-books',
        };
    }

    protected function stringable(): Stringable
    {
        return match ($this) {
            self::AEON => Str::of(self::AEON->name),
            self::HOME => Str::of(self::HOME->name),
            self::GUIDE => Str::of(self::GUIDE->name),
        };
    }
}
