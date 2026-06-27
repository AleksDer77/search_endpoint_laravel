<?php

namespace App\Filters\Products;

use App\DTO\ProductFilterData;
use App\Filters\Contracts\ProductFilterInterface;
use Illuminate\Database\Eloquent\Builder;

class PriceFromFilter implements ProductFilterInterface
{
    public function apply(Builder $query, ProductFilterData $filterData): void
    {
        if ($filterData->priceFrom === null) {
            return;
        }

        $query->where('price', '>=', (float) $filterData->priceFrom);
    }
}
