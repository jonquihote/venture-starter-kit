<?php

namespace Venture\Blueprint\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Str;

enum DocumentationGroupsEnum: string implements HasLabel
{
    case Claude = 'Claude';
    case Aeon = 'Aeon';
    case Alpha = 'Alpha';
    case Omega = 'Omega';

    public function icon(): string
    {
        return match ($this) {
            self::Claude => 'lucide-square-code',
            self::Aeon => 'lucide-shield-half',
            self::Alpha => 'lucide-building',
            self::Omega => 'lucide-users',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Claude => 'bg-orange-500',
            self::Aeon => 'bg-gray-500',
            self::Alpha => 'bg-indigo-500',
            self::Omega => 'bg-purple-500',
        };
    }

    public function slug(): string
    {
        return Str::slug($this->value);
    }

    public function getLabel(): ?string
    {
        return $this->value;
    }
}
