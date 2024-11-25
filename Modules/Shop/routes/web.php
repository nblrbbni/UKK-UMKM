<?php

use Illuminate\Support\Facades\Route;
use Modules\Shop\Http\Controllers\BlogController;
use Modules\Shop\Http\Controllers\CartController;
use Modules\Shop\Http\Controllers\ShopController;
use Modules\Shop\Http\Controllers\OrderController;
use Modules\Shop\Http\Controllers\ContactController;
use Modules\Shop\Http\Controllers\WishlistsController;
use Modules\Shop\Http\Controllers\ProductReviewsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('orders/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('orders/checkout', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/payment/finish', [OrderController::class, 'handlePaymentFinish'])->name('payment.finish');

    Route::get('/shopping-cart', [CartController::class, 'index'])->name('carts.index');
    Route::post('/shopping-cart', [CartController::class, 'store'])->name('carts.store');
    Route::put('/shopping-cart', [CartController::class, 'update'])->name('carts.update');
    Route::get('/shopping-cart/{id}', [CartController::class, 'destroy'])->name('carts.destroy');

    // Wishlists routes
    Route::get('/wishlists', [WishlistsController::class, 'index'])->name('wishlists.index');
    Route::post('/wishlists', [WishlistsController::class, 'store'])->name('wishlists.store');
    Route::delete('/wishlists/{id}', [WishlistsController::class, 'destroy'])->name('wishlists.destroy');

    // Product reviews routes
    Route::get('/reviews/create/{orderId}', [ProductReviewsController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ProductReviewsController::class, 'store'])->name('reviews.store');
});

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/category/{categorySlug}', [ShopController::class, 'category'])->name('shop.category');
Route::get('/{categorySlug}/{productSlug}', [ShopController::class, 'show'])->name('shop.show');

Route::get('/blog', [BlogController::class, 'index']);
Route::get('/contact', [ContactController::class, 'index']);

Route::post('/midtrans/notification', [OrderController::class, 'handleMidtransNotification']);
