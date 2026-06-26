<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ProductQueryBuilder
{
    private array $filterKeys = [
        'q',
        'price_from',
        'price_to',
        'category_id',
        'in_stock',
        'rating_from',
    ];

    public function apply(Builder $query, array $data): Builder
    {
        foreach ($this->filterKeys as $key) {
            if (! isset($data[$key])) {
                continue;
            }

            $method = Str::camel($key);

            if (! method_exists($this, $method)) {
                continue;
            }

            $this->{$method}($query, $data[$key]);
        }

        $this->sort($query, $data['sort'] ?? 'newest');

        return $query;
    }

    private function q(Builder $query, string $value): void
    {
        if ($query->getConnection()->getDriverName() === 'sqlite') {
            $query->where('name', 'like', '%' . $value . '%');
        } else {
            $query->whereFullText('name', $value);
        }
    }

    private function priceFrom(Builder $query, float $value): void
    {
        $query->where('price', '>=', $value);
    }

    private function priceTo(Builder $query, float $value): void
    {
        $query->where('price', '<=', $value);
    }

    private function categoryId(Builder $query, int $value): void
    {
        $query->where('category_id', $value);
    }

    private function inStock(Builder $query, bool $value): void
    {
        $query->where('in_stock', $value);
    }

    private function ratingFrom(Builder $query, float $value): void
    {
        $query->where('rating', '>=', $value);
    }

    private function sort(Builder $query, string $value): void
    {
        match ($value) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'rating_desc' => $query->orderByDesc('rating'),
            default => $query->orderByDesc('created_at'),
        };
    }
}
