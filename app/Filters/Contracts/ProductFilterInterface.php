<?php

namespace App\Filters\Contracts;

use App\DTO\ProductFilterData;
use Illuminate\Database\Eloquent\Builder;

interface ProductFilterInterface
{
    /**
     * Apply the filter to the query.
     */
    public function apply(Builder $query, ProductFilterData $filterData): void;
}
