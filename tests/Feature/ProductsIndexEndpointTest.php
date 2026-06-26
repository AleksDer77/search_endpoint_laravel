<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductsIndexEndpointTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_paginated_products_response(): void
    {
        Product::factory()->count(20)->create();

        $response = $this->getJson('/api/products?per_page=5');

        $response->assertOk()
            ->assertJsonStructure([
                'data',
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next',
                ],
                'meta' => [
                    'current_page',
                    'last_page',
                    'per_page',
                    'total',
                ],
            ]);

        $this->assertCount(5, $response->json('data'));
        $this->assertSame(5, $response->json('meta.per_page'));
    }

    public function test_it_applies_filters_from_query_params(): void
    {
        $categoryA = Category::factory()->create();
        $categoryB = Category::factory()->create();

        $match = Product::factory()->create([
            'name' => 'iPhone 15 Pro',
            'price' => 1299.99,
            'category_id' => $categoryA->id,
            'in_stock' => true,
            'rating' => 4.8,
        ]);

        Product::factory()->create([
            'name' => 'iPhone SE',
            'price' => 499.99,
            'category_id' => $categoryA->id,
            'in_stock' => true,
            'rating' => 4.9,
        ]);

        Product::factory()->create([
            'name' => 'iPhone 15 Pro',
            'price' => 1299.99,
            'category_id' => $categoryB->id,
            'in_stock' => true,
            'rating' => 4.9,
        ]);

        Product::factory()->create([
            'name' => 'iPhone 15 Pro',
            'price' => 1299.99,
            'category_id' => $categoryA->id,
            'in_stock' => false,
            'rating' => 4.9,
        ]);

        $response = $this->getJson('/api/products?q=iPhone&price_from=1000&price_to=1400&category_id=' . $categoryA->id . '&in_stock=1&rating_from=4.5');

        $response->assertOk();
        $this->assertSame([$match->id], array_column($response->json('data'), 'id'));
    }

    public function test_it_applies_sorting_from_query_params(): void
    {
        $category = Category::factory()->create();

        $low = Product::factory()->create(['category_id' => $category->id, 'price' => 100.00]);
        $high = Product::factory()->create(['category_id' => $category->id, 'price' => 300.00]);
        $mid = Product::factory()->create(['category_id' => $category->id, 'price' => 200.00]);

        $response = $this->getJson('/api/products?sort=price_desc');

        $response->assertOk();
        $this->assertSame([$high->id, $mid->id, $low->id], array_column($response->json('data'), 'id'));
    }

    public function test_it_validates_price_range_order(): void
    {
        $response = $this->getJson('/api/products?price_from=1000&price_to=500');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['price_to']);
    }
}
