<?php

namespace App\Filters;

use App\DTO\ProductFilterData;
use App\Filters\Contracts\ProductFilterInterface;
use Illuminate\Database\Eloquent\Builder;

class ProductFilter
{
    /**
     * @param ProductFilterInterface[] $filters
     */
    public function __construct(
        private readonly ProductSorter $sorter,
        private readonly array $filters,
    ) {}

    /**
     * Apply all registered filters and sorting to the query.
     */
    public function apply(Builder $query, ProductFilterData $data): Builder
    {
        $values = [
            'q'           => $data->q,
            'price_from'  => $data->priceFrom,
            'price_to'    => $data->priceTo,
            'category_id' => $data->categoryId,
            'in_stock'    => $data->inStock,
            'rating_from' => $data->ratingFrom,
        ];

        foreach ($this->filters as $filter) {
            $value = $values[$filter->key()] ?? null;

            if ($value !== null) {
                $filter->apply($query, $value);
            }
        }

        $this->sorter->apply($query, $data->sort);

        return $query;
    }
}
