<?php

namespace App\Filters\Products;

use App\DTO\ProductFilterData;
use App\Filters\Contracts\ProductFilterInterface;
use Illuminate\Database\Eloquent\Builder;

class RatingFromFilter implements ProductFilterInterface
{
    public function apply(Builder $query, ProductFilterData $filterData): void
    {
        if ($filterData->ratingFrom === null) {
            return;
        }

        $query->where('rating', '>=', (float) $filterData->ratingFrom);
    }
}
