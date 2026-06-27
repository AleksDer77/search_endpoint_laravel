<?php

namespace Tests\Unit\Filters;

use App\DTO\ProductFilterData;
use App\Filters\Products\CategoryFilter;
use Illuminate\Database\Eloquent\Builder;
use PHPUnit\Framework\TestCase;

class CategoryFilterTest extends TestCase
{
    public function test_it_applies_where_category(): void
    {
        $query = $this->createMock(Builder::class);
        $query->expects($this->once())
            ->method('where')
            ->with('category_id', 3);
        $dto = (new ProductFilterData(categoryId: 3));

        (new CategoryFilter())->apply($query, $dto);
    }

    public function test_it_does_not_apply_when_query_is_null(): void
    {
        $query = $this->createMock(Builder::class);
        $query->expects($this->never())->method('where');

        $dto = (new ProductFilterData(categoryId: null));
        (new CategoryFilter())->apply($query, $dto);
    }
}
