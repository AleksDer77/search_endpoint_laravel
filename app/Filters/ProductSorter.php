<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class ProductSorter
{
    /**
     * Apply sorting to the query builder.
     */
    public function apply(Builder $query, ?string $sort): Builder
    {
        return match ($sort) {
            'price_asc'   => $query->orderBy('price', 'asc'),
            'price_desc'  => $query->orderBy('price', 'desc'),
            'rating_desc' => $query->orderBy('rating', 'desc'),
            default       => $query->orderBy('created_at', 'desc'),
        };
    }
}
