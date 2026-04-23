<?php

declare(strict_types=1);

use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

Route::get('products', [ProductsController::class, 'index']);
