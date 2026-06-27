<?php

namespace Tests\Unit\Filters;

use App\DTO\ProductFilterData;
use App\Filters\Products\PriceToFilter;
use Illuminate\Database\Eloquent\Builder;
use PHPUnit\Framework\TestCase;

class PriceToFilterTest extends TestCase
{
    public function test_it_applies_lte_condition(): void
    {
        $query = $this->createMock(Builder::class);
        $query->expects($this->once())
            ->method('where')
            ->with('price', '<=', 5000.0);

        $dto = (new ProductFilterData(priceTo: 5000.0));

        (new PriceToFilter())->apply($query, $dto);
    }

    public function test_it_does_not_apply_when_query_is_null()
    {
        $query = $this->createMock(Builder::class);
        $query->expects($this->never())->method('where');
        $dto = (new ProductFilterData(priceTo: null));
        (new PriceToFilter())->apply($query, $dto);

    }
}
