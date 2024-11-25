<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Modules\Shop\Http\Controllers\OrdersController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Owner\OwnerLoginController;
use Modules\Shop\Http\Controllers\ProductsController;
use Modules\Shop\Http\Controllers\DiscountsController;
use Modules\Shop\Http\Controllers\WishlistsController;
use Modules\Shop\Http\Controllers\ProductCategoriesController;
use Modules\Shop\Http\Controllers\DiscountCategoriesController;
use Modules\Shop\Http\Controllers\OwnerWishlistsController;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

// Route untuk Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('login'); // Form login admin
    Route::post('login', [AdminLoginController::class, 'login'])->name('login.submit'); // Proses login admin
    Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout'); // Logout admin
    Route::get('dashboard', function () {
        return view('admin.dashboard'); // Dashboard admin
    })->name('dashboard')->middleware('auth:admin'); // Middleware untuk admin

});

// Route untuk Owner
Route::prefix('owner')->name('owner.')->group(function () {
    Route::get('login', [OwnerLoginController::class, 'showLoginForm'])->name('login'); // Form login owner
    Route::post('login', [OwnerLoginController::class, 'login'])->name('login.submit'); // Proses login owner
    Route::post('logout', [OwnerLoginController::class, 'logout'])->name('logout'); // Logout owner
    Route::get('dashboard', function () {
        return view('owner.dashboard'); // Dashboard owner
    })->name('dashboard')->middleware('auth:owner'); // Middleware untuk owner

    // Product Categories route
    Route::get('product-categories', [ProductCategoriesController::class, 'index'])
        ->name('productCategories.index')
        ->middleware('auth:owner');
    Route::get('product-categories/create', [ProductCategoriesController::class, 'create'])
        ->name('productCategories.create')
        ->middleware('auth:owner');
    Route::post('product-categories', [ProductCategoriesController::class, 'store'])
        ->name('productCategories.store')
        ->middleware('auth:owner');
    Route::get('product-categories/{id}/edit', [ProductCategoriesController::class, 'edit'])
        ->name('productCategories.edit')
        ->middleware('auth:owner');
    Route::put('product-categories/{id}', [ProductCategoriesController::class, 'update'])
        ->name('productCategories.update')
        ->middleware('auth:owner');
    Route::delete('product-categories/{id}', [ProductCategoriesController::class, 'destroy'])
        ->name('productCategories.destroy')
        ->middleware('auth:owner');

    // Discount Categories route
    Route::get('discount-categories', [DiscountCategoriesController::class, 'index'])
        ->name('discountCategories.index')
        ->middleware('auth:owner');
    Route::get('discount-categories/create', [DiscountCategoriesController::class, 'create'])
        ->name('discountCategories.create')
        ->middleware('auth:owner');
    Route::post('discount-categories', [DiscountCategoriesController::class, 'store'])
        ->name('discountCategories.store')
        ->middleware('auth:owner');
    Route::get('discount-categories/{id}/edit', [DiscountCategoriesController::class, 'edit'])
        ->name('discountCategories.edit')
        ->middleware('auth:owner');
    Route::put('discount-categories/{id}', [DiscountCategoriesController::class, 'update'])
        ->name('discountCategories.update')
        ->middleware('auth:owner');
    Route::delete('discount-categories/{id}', [DiscountCategoriesController::class, 'destroy'])
        ->name('discountCategories.destroy')
        ->middleware('auth:owner');

    // Discount routes
    Route::get('discounts', [DiscountsController::class, 'index'])
        ->name('discounts.index')
        ->middleware('auth:owner');
    Route::get('discounts/create', [DiscountsController::class, 'create'])
        ->name('discounts.create')
        ->middleware('auth:owner');
    Route::post('discounts', [DiscountsController::class, 'store'])
        ->name('discounts.store')
        ->middleware('auth:owner');
    Route::get('discounts/{id}/edit', [DiscountsController::class, 'edit'])
        ->name('discounts.edit')
        ->middleware('auth:owner');
    Route::put('discounts/{id}', [DiscountsController::class, 'update'])
        ->name('discounts.update')
        ->middleware('auth:owner');
    Route::delete('discounts/{id}', [DiscountsController::class, 'destroy'])
        ->name('discounts.destroy')
        ->middleware('auth:owner');

    // Products routes
    Route::get('products', [ProductsController::class, 'index'])
        ->name('products.index')
        ->middleware('auth:owner');
    Route::get('products/create', [ProductsController::class, 'create'])
        ->name('products.create')
        ->middleware('auth:owner');
    Route::post('products', [ProductsController::class, 'store'])
        ->name('products.store')
        ->middleware('auth:owner');
    Route::get('products/{id}/edit', [ProductsController::class, 'edit'])
        ->name('products.edit')
        ->middleware('auth:owner');
    Route::put('products/{id}', [ProductsController::class, 'update'])
        ->name('products.update')
        ->middleware('auth:owner');
    Route::delete('products/{id}', [ProductsController::class, 'destroy'])
        ->name('products.destroy')
        ->middleware('auth:owner');

    // Orders route
    Route::get('orders', [OrdersController::class, 'index'])
        ->name('orders.index')
        ->middleware('auth:owner');
    Route::get('orders/{id}', [OrdersController::class, 'show'])
        ->name('orders.show')
        ->middleware('auth:owner');

    // Wishlists route
    Route::get('wishlists', [OwnerWishlistsController::class, 'index'])
        ->name('wishlists.index')
        ->middleware('auth:owner');
});
