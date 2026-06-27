<?php

namespace App\Filters;

use App\DTO\ProductFilterData;
use Illuminate\Database\Eloquent\Builder;

class ProductFilter
{
    public function __construct(
        private readonly ProductSorter $sorter,
        private readonly array $filters,
    ) {}

    /**
     * Apply all registered filters and sorting to the query.
     */
    public function apply(Builder $query, ProductFilterData $data): Builder
    {
        foreach ($this->filters as $filter) {
            $filter->apply($query, $data);
        }

        $this->sorter->apply($query, $data->sort);

        return $query;
    }
}
