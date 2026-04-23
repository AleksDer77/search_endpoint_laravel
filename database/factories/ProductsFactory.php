<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Products>
 */
class ProductsFactory extends Factory
{
    protected $model = Products::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'price' => fake()->randomFloat(2, 10, 5000),
            'category_id' => Category::factory(),
            'in_stock' => fake()->boolean(),
            'rating' => fake()->randomFloat(1, 0, 5),
        ];
    }
}
