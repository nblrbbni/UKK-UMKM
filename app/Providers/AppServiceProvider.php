<?php

namespace App\Providers;

use Modules\Shop\Models\Orders;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Modules\Shop\Repositories\Front\ProductRepository;
use Modules\Shop\Repositories\Front\CategoryRepository;
use Modules\Shop\Repositories\Front\Interfaces\ProductRepositoryInterface;
use Modules\Shop\Repositories\Front\Interfaces\CategoryRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(ProductRepositoryInterface $productRepository, CategoryRepositoryInterface $categoryRepository)
    {
        Paginator::useBootstrapFive();

        $product_categories = $categoryRepository->findAll();

        $products = $productRepository->findAll(['per_page' => 8]);

        view()->share('product_categories', $product_categories);
        view()->share('products', $products);

        View::composer('*', function ($view) {
            if (auth('web')->check()) {
                $cartTotal = Orders::where('customer_id', auth('web')->id())
                    ->where('status', 'cart')
                    ->sum('total_amount');

                $view->with('cartTotal', $cartTotal);
            } else {
                $view->with('cartTotal', 0);
            }
        });
    }
}
