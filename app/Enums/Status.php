<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Status: String
{
    case DEFAULT = 'Pending';
    case APPROVED = 'Approved';
    case REJECTED = 'Rejected';
}