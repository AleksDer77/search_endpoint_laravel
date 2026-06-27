<?php

namespace Tests\Unit\Filters;

use App\DTO\ProductFilterData;
use App\Filters\Products\RatingFromFilter;
use Illuminate\Database\Eloquent\Builder;
use PHPUnit\Framework\TestCase;

class RatingFromFilterTest extends TestCase
{
    public function test_it_applies_gte_condition(): void
    {
        $query = $this->createMock(Builder::class);
        $query->expects($this->once())
            ->method('where')
            ->with('rating', '>=', 4.5);

        $dto = (new ProductFilterData(ratingFrom: 4.5));
        (new RatingFromFilter())->apply($query, $dto);
    }

    public function test_it_does_not_apply_when_query_is_null()
    {
        $query = $this->createMock(Builder::class);
        $query->expects($this->never())->method('where');
        $dto = (new ProductFilterData(ratingFrom: null));
        (new RatingFromFilter())->apply($query, $dto);
    }
}
