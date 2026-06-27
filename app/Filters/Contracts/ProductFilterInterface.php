<?php

namespace App\Filters\Contracts;

use App\DTO\ProductFilterData;
use Illuminate\Database\Eloquent\Builder;

interface ProductFilterInterface
{
    /**
     * Return the query parameter key this filter handles.
     */
    public function key(): string;

    /**
     * Apply the filter to the query.
     */
    public function apply(Builder $query, ProductFilterData $filterData): void;
}
