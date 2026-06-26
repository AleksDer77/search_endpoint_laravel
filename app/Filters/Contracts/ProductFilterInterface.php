<?php

namespace App\Filters\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface ProductFilterInterface
{
    /**
     * Return the query parameter key this filter handles.
     */
    public function key(): string;

    /**
     * Apply the filter to the query.
     */
    public function apply(Builder $query, mixed $value): void;
}
