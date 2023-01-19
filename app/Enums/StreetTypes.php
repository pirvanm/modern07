<?php

namespace App\Enums;

use App\Traits\EnumsToArray;

enum StreetTypes: string
{
    use EnumsToArray;

    case UNKNOWN = '';
    case Entrance  = 'Entrance';
    case Alley = 'Alley';
    case Street = 'Street';
    case Boulevard = 'Boulevard';
    case DN = 'DN';
    case Road = 'Road';
}
