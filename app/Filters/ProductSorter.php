<?php

namespace App\Filters;

use App\Enums\ProductSort;
use Illuminate\Database\Eloquent\Builder;

class ProductSorter
{
    /**
     * Apply sorting to the query builder.
     */
    public function apply(Builder $query, ?ProductSort $sort): Builder
    {
        $sortEnum = $sort ?? ProductSort::NEWEST;

        return match ($sortEnum) {
            ProductSort::PRICE_ASC   => $query->orderBy('price', 'asc'),
            ProductSort::PRICE_DESC  => $query->orderBy('price', 'desc'),
            ProductSort::RATING_DESC => $query->orderBy('rating', 'desc'),
            ProductSort::NEWEST      => $query->orderBy('created_at', 'desc'),
        };
    }
}
