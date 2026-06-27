<?php

namespace App\Filters;

use App\DTO\ProductFilterData;
use App\Filters\Contracts\ProductFilterInterface;
use Illuminate\Database\Eloquent\Builder;

class ProductFilter
{
    public function __construct(
        private readonly ProductSorter $sorter,
    ) {}

    /**
     * Apply all registered filters and sorting to the query.
     */
    public function apply(Builder $query, ProductFilterData $data): Builder
    {
        foreach ($this->filters as $filter) {
            $value = $values[$filter->key()] ?? null;

            if ($value !== null) {
                $filter->apply($query, $value);
            }
        }

        $this->sorter->apply($query, $data->sort);

        return $query;
    }
}
