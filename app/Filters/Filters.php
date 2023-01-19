<?php

namespace App\Filters;

use Illuminate\Http\Request;
use App\Helpers\FilterOperatorsMapper;

abstract class Filters
{
    private $stringOperators = array(
        'eq' => 'LIKE',
        'neq' => 'NOT LIKE',
        'doesnotcontain' => 'NOT LIKE',
        'contains' => 'LIKE',
        'startswith' => 'LIKE',
        'endswith' => 'LIKE',
        'isnull' => 'IS',
        'isnotnull' => 'IS NOT',
        'isempty' => '==',
        'isnotempty' => '!='
    );

    private $operators = array(
        'eq' => '=',
        'gt' => '>',
        'gte' => '>=',
        'lt' => '<',
        'lte' => '<=',
        'neq' => '!=',
        'isnull' => 'IS',
        'isnotnull' => 'IS NOT'
    );
}
