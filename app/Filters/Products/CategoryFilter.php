<?php

namespace App\Filters\Products;

use App\Filters\Contracts\ProductFilterInterface;
use Illuminate\Database\Eloquent\Builder;

class CategoryFilter implements ProductFilterInterface
{
    public function key(): string
    {
        return 'category_id';
    }

    public function apply(Builder $query, mixed $value): void
    {
        $query->where('category_id', (int) $value);
    }
}
