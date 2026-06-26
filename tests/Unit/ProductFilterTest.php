<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_filters_by_query_and_price_range(): void
    {
        $category = Category::factory()->create();

        $match = Product::factory()->create([
            'name' => 'iPhone 15',
            'price' => 1500.00,
            'category_id' => $category->id,
        ]);

        Product::factory()->create([
            'name' => 'Samsung Galaxy',
            'price' => 1200.00,
            'category_id' => $category->id,
        ]);

        Product::factory()->create([
            'name' => 'iPhone SE',
            'price' => 500.00,
            'category_id' => $category->id,
        ]);

        $query = Product::filter([
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

        $match = Product::factory()->create([
            'category_id' => $categoryA->id,
            'in_stock' => true,
            'rating' => 4.7,
        ]);

        Product::factory()->create([
            'category_id' => $categoryA->id,
            'in_stock' => false,
            'rating' => 4.9,
        ]);

        Product::factory()->create([
            'category_id' => $categoryB->id,
            'in_stock' => true,
            'rating' => 4.8,
        ]);

        $query = Product::filter([
            'category_id' => $categoryA->id,
            'in_stock' => true,
            'rating_from' => 4.5,
        ]);

        $this->assertSame([$match->id], $query->pluck('id')->all());
    }

    public function test_it_sorts_by_price_desc(): void
    {
        $category = Category::factory()->create();

        $p1 = Product::factory()->create(['category_id' => $category->id, 'price' => 100.00]);
        $p2 = Product::factory()->create(['category_id' => $category->id, 'price' => 300.00]);
        $p3 = Product::factory()->create(['category_id' => $category->id, 'price' => 200.00]);

        $query = Product::filter([
            'sort' => 'price_desc',
        ]);

        $this->assertSame([$p2->id, $p3->id, $p1->id], $query->pluck('id')->all());
    }

    public function test_it_uses_newest_sort_by_default(): void
    {
        $category = Category::factory()->create();

        $old = Product::factory()->create([
            'category_id' => $category->id,
            'created_at' => now()->subDays(2),
        ]);
        $new = Product::factory()->create([
            'category_id' => $category->id,
            'created_at' => now(),
        ]);

        $query = Product::filter([]);

        $this->assertSame([$new->id, $old->id], $query->pluck('id')->all());
    }
}
