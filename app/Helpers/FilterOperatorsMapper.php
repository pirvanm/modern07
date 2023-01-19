<?php

namespace App\Helpers;

class FilterOperatorsMapper
{
    private array $mappings;

    public function __construct()
    {
        $this->mappings = [
            'contains' => 'like',
            'neq' => '!=',
            'eq' => '='
        ];
    }

    public function mapOperator(string $operator): string {
        return $this->mappings[$operator];
    }


}
