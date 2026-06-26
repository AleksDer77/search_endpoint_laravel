<?php

namespace App\Filters\Products;

use App\Filters\Contracts\ProductFilterInterface;
use Illuminate\Database\Eloquent\Builder;

class PriceToFilter implements ProductFilterInterface
{
    public function key(): string
    {
        return 'price_to';
    }

    public function apply(Builder $query, mixed $value): void
    {
        $query->where('price', '<=', (float) $value);
    }
}
