<?php

namespace App\Traits;

trait TelerikGridFilters
{
    protected $operators = [
        'eg' => '=',
        'gt' => '>',
        'gte' => '>=',
        'lt' => '<',
        'lte' => '<=',
        'neg' => '!=',
        'startwith' => 'like',
        'contains' => 'like',
        'doesnotcontain' => 'not like',
        'endwith' => 'like',
        'isnull' => '=',
        'isnotnull' => '!=',
        'isempty' => '=',
        'isnotempty' => '!='
    ];

    protected function processColumnValue(string $operator, string $columnValue)
    {
        switch ($operator) {
            case 'startswith':
                $value = $columnValue . '%';
                break;
            case 'endswith':
                $value = '%' . $columnValue;
                break;
            case'contains':
                $value = '%' . $columnValue . '%';
                break;
            case 'isnull':
            case 'isnotnull':
                $value = null;
                break;
            case'isempty':
            case 'isnotempty':
                $value = '';
                break;
            default:
                $value = $columnValue;
                break;

        }

        return $value;
    }

    public function scopeFilters($query, $filterColumns)
    {
        if (count($filterColumns)) {
            $query->where(function ($query) use ($filterColumns) {

                foreach ($filterColumns as $filterColumn) {
                    $logic = $filterColumn['logic'];

                    foreach ($filterColumn['filters'] as $index => $filter) {
                        $operator = $this->operators[$filter['operator']];

                        //process field value
                        $value = $this->processColumnValue($filter['operator'], $filter['value']);

                        $field = $filter['field'];

                        //to append the table prefix if not found
                        if (!str_contains($filter['field'], '.')) {
                            $field = $this->getTable() . '.' . $filter['field'];
                        }

                        //if we have logic operation "OR"
                        if ($index === 1 && $logic === "or") {
                            $query->orWhere($field, $operator, $value);
                        } else {
                            $query->where($field, $operator, $value);
                        }
                    }
                }
            });
        }


    }

    public function scopeSort($query, $sort)
    {
        if (count($sort)) {
            $sortField = $sort[0]['field'];
            $sortDir = $sort[0]['dir'];

            $query->orderBy($sortField, $sortDir);
        }
    }
}
