<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum NamePrefix: string implements HasLabel
{
    case Mr = 'Mr.';
    case Mrs = 'Mrs.';
    case Ms = 'Ms.';
    case Dr = 'Dr.';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Mr => 'Mr.',
            self::Mrs => 'Mrs.',
            self::Ms => 'Ms.',
            self::Dr => 'Dr.',
        };
    }
}