<?php

namespace App\Filters\Products;

use App\DTO\ProductFilterData;
use App\Filters\Contracts\ProductFilterInterface;
use Illuminate\Database\Eloquent\Builder;

class InStockFilter implements ProductFilterInterface
{
    public function apply(Builder $query, ProductFilterData $filterData): void
    {
        if ($filterData->inStock === null) {
            return;
        }

        $query->where('in_stock', filter_var($filterData->inStock, FILTER_VALIDATE_BOOLEAN));
    }
}
