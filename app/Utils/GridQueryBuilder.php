<?php

namespace App\Utils;

use App\Helpers\FilterOperatorsMapper;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;

class GridQueryBuilder
{
    private Request $request;
    private FilterOperatorsMapper $operatorsMapper;
    private $gridParams;

    #[Pure] public function __construct(Request $request)
    {
        $this->request = $request;
        $this->operatorsMapper = new FilterOperatorsMapper();
        $this->gridParams = json_decode($this->request->body);
    }

    private function _getRawFilters(): array
    {
        return $this->gridParams->filters;
    }

    private function getFormattedFilters(): string
    {
        return sprintf('WHERE %s', implode(' AND ', $this->formatFilters()));
    }

    private function _getWrappedValues(): array
    {
        return array_map(fn (\stdClass $filter) => [
            ...get_object_vars($filter), 'value' => $filter->operator === 'contains' ? sprintf("'%%%s%%'", $filter->value) : $filter->value
        ], $this->_getRawFilters());
    }

    private function formatFilters(): array
    {
        return array_map(fn ($filter) => sprintf(
            '%s %s %s',
            $filter['field'],
            $this->operatorsMapper->mapOperator($filter['operator']),
            $filter['value']
        ), $this->_getWrappedValues());
    }


    public function getQuery(): string
    {
        $filtersString = '';
        if (!empty($this->gridParams->filters)) {
            $filtersString = $this->getFormattedFilters();
        }

        return sprintf('SELECT * FROM %s %s;', $this->gridParams->dataSource, $filtersString);
    }
}
