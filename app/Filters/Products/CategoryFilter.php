<?php

namespace App\Filters\Products;

use App\DTO\ProductFilterData;
use App\Filters\Contracts\ProductFilterInterface;
use Illuminate\Database\Eloquent\Builder;

class CategoryFilter implements ProductFilterInterface
{
    public function apply(Builder $query, ProductFilterData $filterData): void
    {
        if ($filterData->categoryId === null) {
            return;
        }
        $query->where('category_id', $filterData->categoryId);
    }
}
