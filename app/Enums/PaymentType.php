<?php

namespace App\Enums;

use App\Traits\EnumsToArray;

enum PaymentType: string
{
    use EnumsToArray;

    case UNKNOWN = '';
    case MONTHLY= 'lunara';
    case QUARTERLY = 'trimestrial';
    case SEMESTER= 'semestrial';
    case ANNUAL = 'anual';

}
