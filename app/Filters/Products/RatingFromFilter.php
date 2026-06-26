<?php

namespace App\Filters\Products;

use App\Filters\Contracts\ProductFilterInterface;
use Illuminate\Database\Eloquent\Builder;

class RatingFromFilter implements ProductFilterInterface
{
    public function key(): string
    {
        return 'rating_from';
    }

    public function apply(Builder $query, mixed $value): void
    {
        $query->where('rating', '>=', (float) $value);
    }
}
