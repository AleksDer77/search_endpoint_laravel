<?php

namespace App\Providers;

use App\Filters\Contracts\ProductFilterInterface;
use App\Filters\ProductFilter;
use App\Filters\Products\CategoryFilter;
use App\Filters\Products\InStockFilter;
use App\Filters\Products\PriceFromFilter;
use App\Filters\Products\PriceToFilter;
use App\Filters\Products\RatingFromFilter;
use App\Filters\Products\SearchFilter;
use App\Filters\ProductSorter;
use Illuminate\Support\ServiceProvider;

class FilterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ProductFilter::class, function ($app) {
            $filters = [];
            $files = glob(app_path('Filters/Products/*.php')) ? : [];
            foreach ($files as $file) {
                $className = 'App\\Filters\\Products\\'.pathinfo($file, PATHINFO_FILENAME);

                if (class_exists($className) && is_subclass_of($className, ProductFilterInterface::class)) {
                    $filters[] = $app->make($className);
                }
            }
            return new ProductFilter(
                $app->make(ProductSorter::class),
                $filters
            );
        }
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
