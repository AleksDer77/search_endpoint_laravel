<?php

namespace App\Http\Controllers;

use App\Filters\ProductQueryBuilder;
use App\Http\Requests\ProductsIndexRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductsController extends Controller
{
    public function __construct(
        private readonly ProductQueryBuilder $productQueryBuilder
    ) {}

    public function index(ProductsIndexRequest $request)
    {
        $data = $request->validated();
        $query = $this->productQueryBuilder->apply(Product::query(), $data);

        $perPage = $data['per_page'] ?? 15;

        $products = $query->paginate($perPage)->appends($request->query());

        return ProductResource::collection($products);
    }
}
