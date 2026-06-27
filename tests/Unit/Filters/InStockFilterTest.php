<?php

namespace Tests\Unit\Filters;

use App\DTO\ProductFilterData;
use App\Filters\Products\InStockFilter;
use Illuminate\Database\Eloquent\Builder;
use PHPUnit\Framework\TestCase;

class InStockFilterTest extends TestCase
{
    public function test_it_filters_in_stock_true(): void
    {
        $query = $this->createMock(Builder::class);
        $query->expects($this->once())
            ->method('where')
            ->with('in_stock', true);
        $dto = (new ProductFilterData(inStock: true));

        (new InStockFilter())->apply($query, $dto);
    }

    public function test_it_filters_in_stock_false(): void
    {
        $query = $this->createMock(Builder::class);
        $query->expects($this->once())
            ->method('where')
            ->with('in_stock', false);

        $dto = (new ProductFilterData(inStock: false));

        (new InStockFilter())->apply($query, $dto);
    }

    public function test_it_casts_string_true_to_bool(): void
    {
        $query = $this->createMock(Builder::class);
        $query->expects($this->once())
            ->method('where')
            ->with('in_stock', true);

        $dto = (new ProductFilterData(inStock: 1));
        (new InStockFilter())->apply($query, $dto);
    }

    public function test_it_does_not_apply_when_query_is_null()
    {
        $query = $this->createMock(Builder::class);
        $query->expects($this->never())->method('where');
        $dto = (new ProductFilterData(inStock: null));
        (new InStockFilter())->apply($query, $dto);

    }
}
