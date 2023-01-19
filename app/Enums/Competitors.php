<?php

namespace App\Enums;

use App\Traits\EnumsToArray;

enum Competitors: string
{
    use EnumsToArray;

    case UNKNOWN = '';
    case SUPERBET= 'Superbet';
    case UNIBET = 'Unibet';
    case BETANO= 'Betano';
    case MOZZARTBET = 'Mozzart Bet';
    case SPORT = '888SPORT';


}
