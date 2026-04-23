<?php

namespace Tests\Unit;

use App\Filters\ProductQueryBuilder;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductQueryBuilderTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_filters_by_query_and_price_range(): void
    {
        $category = Category::factory()->create();

        $match = Products::factory()->create([
            'name' => 'iPhone 15',
            'price' => 1500.00,
            'category_id' => $category->id,
        ]);

        Products::factory()->create([
            'name' => 'Samsung Galaxy',
            'price' => 1200.00,
            'category_id' => $category->id,
        ]);

        Products::factory()->create([
            'name' => 'iPhone SE',
            'price' => 500.00,
            'category_id' => $category->id,
        ]);

        $query = app(ProductQueryBuilder::class)->apply(Products::query(), [
            'q' => 'iPhone',
            'price_from' => 1000.0,
            'price_to' => 2000.0,
        ]);

        $this->assertSame([$match->id], $query->pluck('id')->all());
    }

    public function test_it_filters_by_category_stock_and_rating(): void
    {
        $categoryA = Category::factory()->create();
        $categoryB = Category::factory()->create();

        $match = Products::factory()->create([
            'category_id' => $categoryA->id,
            'in_stock' => true,
            'rating' => 4.7,
        ]);

        Products::factory()->create([
            'category_id' => $categoryA->id,
            'in_stock' => false,
            'rating' => 4.9,
        ]);

        Products::factory()->create([
            'category_id' => $categoryB->id,
            'in_stock' => true,
            'rating' => 4.8,
        ]);

        $query = app(ProductQueryBuilder::class)->apply(Products::query(), [
            'category_id' => $categoryA->id,
            'in_stock' => true,
            'rating_from' => 4.5,
        ]);

        $this->assertSame([$match->id], $query->pluck('id')->all());
    }

    public function test_it_sorts_by_price_desc(): void
    {
        $category = Category::factory()->create();

        $p1 = Products::factory()->create(['category_id' => $category->id, 'price' => 100.00]);
        $p2 = Products::factory()->create(['category_id' => $category->id, 'price' => 300.00]);
        $p3 = Products::factory()->create(['category_id' => $category->id, 'price' => 200.00]);

        $query = app(ProductQueryBuilder::class)->apply(Products::query(), [
            'sort' => 'price_desc',
        ]);

        $this->assertSame([$p2->id, $p3->id, $p1->id], $query->pluck('id')->all());
    }

    public function test_it_uses_newest_sort_by_default(): void
    {
        $category = Category::factory()->create();

        $old = Products::factory()->create([
            'category_id' => $category->id,
            'created_at' => now()->subDays(2),
        ]);
        $new = Products::factory()->create([
            'category_id' => $category->id,
            'created_at' => now(),
        ]);

        $query = app(ProductQueryBuilder::class)->apply(Products::query(), []);

        $this->assertSame([$new->id, $old->id], $query->pluck('id')->all());
    }
}
