<?php

namespace App\Filters\Products;

use App\DTO\ProductFilterData;
use App\Filters\Contracts\ProductFilterInterface;
use Illuminate\Database\Eloquent\Builder;

class CategoryFilter implements ProductFilterInterface
{
    public function key(): string
    {
        return 'category_id';
    }

    public function apply(Builder $query, ProductFilterData $filterData): void
    {
        if ($filterData->categoryId !== null) {
            $query->where('category_id', $filterData->categoryId);
        }
    }
}
