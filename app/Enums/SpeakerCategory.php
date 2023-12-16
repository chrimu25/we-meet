<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum SpeakerCategory: string implements HasLabel
{
    case MAIN = 'Main Speaker';
    case GUEST = 'Guest Speaker';
    case HONOR = 'Guest of Honor';
    case KEYNOTE = 'Keynote Speaker';
    case MODERATOR = 'Moderator';
    case PANELIST = 'Panelist';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::MAIN => 'Main Speaker',
            self::GUEST => 'Guest Speaker',
            self::HONOR => 'Guest of Honor',
            self::KEYNOTE => 'Keynote Speaker',
            self::MODERATOR => 'Moderator',
            self::PANELIST => 'Panelist',
        };
    }
}