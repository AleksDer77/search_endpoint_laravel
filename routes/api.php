<?php

declare(strict_types=1);

use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:60,1')->group(function () {
    Route::get('products', [ProductsController::class, 'index']);
});
