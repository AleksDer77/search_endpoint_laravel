<?php

namespace Tests\Unit\Filters;

use App\Filters\Products\PriceFromFilter;
use Illuminate\Database\Eloquent\Builder;
use PHPUnit\Framework\TestCase;

class PriceFromFilterTest extends TestCase
{
    public function test_key_returns_price_from(): void
    {
        $this->assertSame('price_from', (new PriceFromFilter())->key());
    }

    public function test_it_applies_gte_condition(): void
    {
        $query = $this->createMock(Builder::class);
        $query->expects($this->once())
            ->method('where')
            ->with('price', '>=', 1000.0);

        (new PriceFromFilter())->apply($query, '1000');
    }

    public function test_it_casts_value_to_float(): void
    {
        $query = $this->createMock(Builder::class);
        $query->expects($this->once())
            ->method('where')
            ->with('price', '>=', 99.99);

        (new PriceFromFilter())->apply($query, '99.99');
    }
}
