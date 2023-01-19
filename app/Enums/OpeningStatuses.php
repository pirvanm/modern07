<?php

namespace App\Enums;

use App\Traits\EnumsToArray;

enum OpeningStatuses: string
{
    use EnumsToArray;

    case NEW = "noua";
    case IN_WORK = "in lucru";
    case WITHDRAWN = "retrasa";
    case FINALISED = "finalizata";
    case OPEN = "deschisa";
    case GENERATED = "generata";
}
