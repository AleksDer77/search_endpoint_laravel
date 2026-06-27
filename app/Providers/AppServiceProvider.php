<?php

namespace App\Providers;

use App\Filters\ProductFilter;
use App\Filters\ProductSorter;
use App\Filters\Products\CategoryFilter;
use App\Filters\Products\InStockFilter;
use App\Filters\Products\PriceFromFilter;
use App\Filters\Products\PriceToFilter;
use App\Filters\Products\RatingFromFilter;
use App\Filters\Products\SearchFilter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
      }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
