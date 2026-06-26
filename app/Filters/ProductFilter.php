<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class ProductFilter
{
    /**
     * Apply the filters to the product query builder.
     */
    public function apply(Builder $query, array $filters): Builder
    {
        if (!empty($filters['q'])) {
            $query->where('name', 'LIKE', '%' . $filters['q'] . '%');
        }

        if (isset($filters['price_from'])) {
            $query->where('price', '>=', (float) $filters['price_from']);
        }

        if (isset($filters['price_to'])) {
            $query->where('price', '<=', (float) $filters['price_to']);
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', (int) $filters['category_id']);
        }

        if (isset($filters['in_stock'])) {
            $query->where('in_stock', filter_var($filters['in_stock'], FILTER_VALIDATE_BOOLEAN));
        }

        if (isset($filters['rating_from'])) {
            $query->where('rating', '>=', (float) $filters['rating_from']);
        }

        $this->sort($query, $filters['sort'] ?? 'newest');

        return $query;
    }

    /**
     * Apply sorting to the query builder.
     */
    private function sort(Builder $query, string $sort): void
    {
        match ($sort) {
            'price_asc'   => $query->orderBy('price', 'asc'),
            'price_desc'  => $query->orderBy('price', 'desc'),
            'rating_desc' => $query->orderBy('rating', 'desc'),
            default       => $query->orderBy('created_at', 'desc'),
        };
    }
}
