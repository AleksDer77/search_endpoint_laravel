<?php

namespace Tests\Unit\Filters;

use App\DTO\ProductFilterData;
use App\Filters\Products\PriceFromFilter;
use Illuminate\Database\Eloquent\Builder;
use PHPUnit\Framework\TestCase;

class PriceFromFilterTest extends TestCase
{
    public function test_it_applies_gte_condition(): void
    {
        $query = $this->createMock(Builder::class);
        $query->expects($this->once())
            ->method('where')
            ->with('price', '>=', 1000.0);

        $dto = (new ProductFilterData(priceFrom: 1000.0));

        (new PriceFromFilter())->apply($query, $dto);
    }

    public function test_it_does_not_apply_when_query_is_null()
    {
        $query = $this->createMock(Builder::class);
        $query->expects($this->never())->method('where');
        $dto = (new ProductFilterData(priceFrom: null));
        (new PriceFromFilter())->apply($query, $dto);
    }
}
