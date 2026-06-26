<?php

namespace App\Http\Controllers;

use App\DTO\ProductFilterData;
use App\Filters\ProductFilter;
use App\Http\Requests\ProductsIndexRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductsController extends Controller
{
    public function __construct(
        private readonly ProductFilter $filter,
    ) {}

    public function index(ProductsIndexRequest $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $dto = ProductFilterData::fromRequest($request);

        $products = $this->filter
            ->apply(Product::query()->with('category'), $dto)
            ->paginate($request->integer('per_page', 15))
            ->appends($request->query());

        return ProductResource::collection($products);
    }
}
