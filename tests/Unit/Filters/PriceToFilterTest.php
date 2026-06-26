<?php

namespace Tests\Unit\Filters;

use App\Filters\Products\PriceToFilter;
use Illuminate\Database\Eloquent\Builder;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

class PriceToFilterTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function test_key_returns_price_to(): void
    {
        $this->assertSame('price_to', (new PriceToFilter())->key());
    }

    public function test_it_applies_lte_condition(): void
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
            ->once()
            ->with('price', '<=', 5000.0);

        (new PriceToFilter())->apply($query, '5000');
    }

    public function test_it_casts_value_to_float(): void
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
            ->once()
            ->with('price', '<=', 299.99);

        (new PriceToFilter())->apply($query, '299.99');
    }
}
