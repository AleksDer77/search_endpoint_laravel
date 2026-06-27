<?php

namespace App\Filters\Products;

use App\DTO\ProductFilterData;
use App\Filters\Contracts\ProductFilterInterface;
use Illuminate\Database\Eloquent\Builder;

class SearchFilter implements ProductFilterInterface
{
    public function apply(Builder $query, ProductFilterData $filterData): void
    {
        if ($filterData->q === null) {
            return;
        }

        $query->where('name', 'LIKE', '%' . $filterData->q . '%');
    }
}
