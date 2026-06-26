<?php

namespace Tests\Unit\Filters;

use App\Filters\Products\SearchFilter;
use Illuminate\Database\Eloquent\Builder;
use PHPUnit\Framework\TestCase;

class SearchFilterTest extends TestCase
{
    public function test_key_returns_q(): void
    {
        $this->assertSame('q', (new SearchFilter())->key());
    }

    public function test_it_applies_like_search(): void
    {
        $query = $this->createMock(Builder::class);
        $query->expects($this->once())
            ->method('where')
            ->with('name', 'LIKE', '%iPhone%');

        (new SearchFilter())->apply($query, 'iPhone');
    }

    public function test_it_skips_empty_string(): void
    {
        $query = $this->createMock(Builder::class);
        $query->expects($this->never())->method('where');

        (new SearchFilter())->apply($query, '');
    }
}
