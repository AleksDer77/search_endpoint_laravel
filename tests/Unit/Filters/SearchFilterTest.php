<?php

namespace Tests\Unit\Filters;

use App\DTO\ProductFilterData;
use App\Filters\Products\SearchFilter;
use Illuminate\Database\Eloquent\Builder;
use PHPUnit\Framework\TestCase;

class SearchFilterTest extends TestCase
{
    public function test_it_applies_like_search(): void
    {
        $query = $this->createMock(Builder::class);
        $query->expects($this->once())
            ->method('where')
            ->with('name', 'LIKE', '%iPhone%');

        $dto = (new ProductFilterData(q: 'iPhone'));

        (new SearchFilter())->apply($query, $dto);
    }

    public function test_it_does_not_apply_when_query_is_null()
    {
        $query = $this->createMock(Builder::class);
        $query->expects($this->never())->method('where');
        $dto = (new ProductFilterData(q: null));
        (new SearchFilter())->apply($query, $dto);
    }
}
