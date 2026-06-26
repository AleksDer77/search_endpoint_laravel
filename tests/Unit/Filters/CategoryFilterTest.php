<?php

namespace Tests\Unit\Filters;

use App\Filters\Products\CategoryFilter;
use Illuminate\Database\Eloquent\Builder;
use PHPUnit\Framework\TestCase;

class CategoryFilterTest extends TestCase
{
    public function test_key_returns_category_id(): void
    {
        $this->assertSame('category_id', (new CategoryFilter())->key());
    }

    public function test_it_applies_where_category(): void
    {
        $query = $this->createMock(Builder::class);
        $query->expects($this->once())
            ->method('where')
            ->with('category_id', 3);

        (new CategoryFilter())->apply($query, '3');
    }

    public function test_it_casts_value_to_int(): void
    {
        $query = $this->createMock(Builder::class);
        $query->expects($this->once())
            ->method('where')
            ->with('category_id', 7);

        (new CategoryFilter())->apply($query, 7.9);
    }
}
