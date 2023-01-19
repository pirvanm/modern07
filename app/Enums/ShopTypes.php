<?php

namespace App\Enums;

use App\Traits\EnumsToArray;

enum ShopTypes: string
{
    use EnumsToArray;

    case CASA_JV  = 'CASA JV';
    case CASA_OWN = 'CASA OWN';
    case FORTUNA_JV = 'FTN JV';
    case FORTUNA_OWN = 'FTN OWN';
    case FORTUNA_JV2 = 'FTN JV2';
    case FORTUNA_SSBT = 'FTN SSBT';
    case CASA_SSBT = 'CASA SSBT';
}
