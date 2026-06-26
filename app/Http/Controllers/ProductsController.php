<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsIndexRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductsController extends Controller
{
    public function index(ProductsIndexRequest $request)
    {
        $products = Product::query()
            ->with('category')
            ->filter($request->validated())
            ->paginate($request->integer('per_page', 15))
            ->appends($request->query());

        return ProductResource::collection($products);
    }
}
