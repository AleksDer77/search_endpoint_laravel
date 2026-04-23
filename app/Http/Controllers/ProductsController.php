<?php

namespace App\Http\Controllers;

use App\Filters\ProductQueryBuilder;
use App\Http\Requests\ProductsIndexRequest;
use App\Http\Resources\ProductResource;
use App\Models\Products;

class ProductsController extends Controller
{
    public function __construct(
        private readonly ProductQueryBuilder $productQueryBuilder
    ) {}

    public function index(ProductsIndexRequest $request)
    {
        $data = $request->validated();
        $query = $this->productQueryBuilder->apply(Products::query(), $data);

        $perPage = $data['per_page'] ?? 15;

        $products = $query->paginate($perPage)->appends($request->query());

        return ProductResource::collection($products);
    }
}
