<?php

namespace App\Filters\Products;

use App\Filters\Contracts\ProductFilterInterface;
use Illuminate\Database\Eloquent\Builder;

class SearchFilter implements ProductFilterInterface
{
    public function key(): string
    {
        return 'q';
    }

    public function apply(Builder $query, mixed $value): void
    {
        if (empty($value)) {
            return;
        }

        $query->where('name', 'LIKE', '%' . $value . '%');
    }
}
