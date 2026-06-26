<?php

namespace Tests\Unit\Filters;

use App\Filters\Products\RatingFromFilter;
use Illuminate\Database\Eloquent\Builder;
use PHPUnit\Framework\TestCase;

class RatingFromFilterTest extends TestCase
{
    public function test_key_returns_rating_from(): void
    {
        $this->assertSame('rating_from', (new RatingFromFilter())->key());
    }

    public function test_it_applies_gte_condition(): void
    {
        $query = $this->createMock(Builder::class);
        $query->expects($this->once())
            ->method('where')
            ->with('rating', '>=', 4.5);

        (new RatingFromFilter())->apply($query, '4.5');
    }

    public function test_it_casts_value_to_float(): void
    {
        $query = $this->createMock(Builder::class);
        $query->expects($this->once())
            ->method('where')
            ->with('rating', '>=', 3.0);

        (new RatingFromFilter())->apply($query, '3');
    }
}
