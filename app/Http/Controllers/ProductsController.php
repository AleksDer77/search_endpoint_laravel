<?php

namespace App\Http\Controllers;

use App\Filters\ProductFilter;
use App\Http\Requests\ProductsIndexRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductsController extends Controller
{
    public function __construct(
        private readonly ProductFilter $filter
    ) {}

    public function index(ProductsIndexRequest $request)
    {
        $query = Product::query()->with('category');

        $products = $this->filter->apply($query, $request->validated())
            ->paginate($request->integer('per_page', 15))
            ->appends($request->query());

        return ProductResource::collection($products);
    }
}
