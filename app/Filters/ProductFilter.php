<?php

namespace App\Filters;

use App\Filters\Contracts\ProductFilterInterface;
use Illuminate\Database\Eloquent\Builder;

class ProductFilter
{
    /**
     * @param ProductFilterInterface[] $filters
     */
    public function __construct(
        private readonly ProductSorter $sorter,
        private readonly array $filters,
    ) {}

    /**
     * Apply all registered filters and sorting to the query.
     */
    public function apply(Builder $query, array $data): Builder
    {
        foreach ($this->filters as $filter) {
            $value = $data[$filter->key()] ?? null;

            if ($value !== null) {
                $filter->apply($query, $value);
            }
        }

        $this->sorter->apply($query, $data['sort'] ?? null);

        return $query;
    }
}
