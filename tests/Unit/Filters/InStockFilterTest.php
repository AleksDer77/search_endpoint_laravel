<?php

namespace Tests\Unit\Filters;

use App\Filters\Products\InStockFilter;
use Illuminate\Database\Eloquent\Builder;
use PHPUnit\Framework\TestCase;

class InStockFilterTest extends TestCase
{
    public function test_key_returns_in_stock(): void
    {
        $this->assertSame('in_stock', (new InStockFilter())->key());
    }

    public function test_it_filters_in_stock_true(): void
    {
        $query = $this->createMock(Builder::class);
        $query->expects($this->once())
            ->method('where')
            ->with('in_stock', true);

        (new InStockFilter())->apply($query, true);
    }

    public function test_it_filters_in_stock_false(): void
    {
        $query = $this->createMock(Builder::class);
        $query->expects($this->once())
            ->method('where')
            ->with('in_stock', false);

        (new InStockFilter())->apply($query, false);
    }

    public function test_it_casts_string_true_to_bool(): void
    {
        $query = $this->createMock(Builder::class);
        $query->expects($this->once())
            ->method('where')
            ->with('in_stock', true);

        (new InStockFilter())->apply($query, '1');
    }
}
