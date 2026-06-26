<?php

namespace App\Filters\Products;

use App\Filters\Contracts\ProductFilterInterface;
use Illuminate\Database\Eloquent\Builder;

class InStockFilter implements ProductFilterInterface
{
    public function key(): string
    {
        return 'in_stock';
    }

    public function apply(Builder $query, mixed $value): void
    {
        $query->where('in_stock', filter_var($value, FILTER_VALIDATE_BOOLEAN));
    }
}
