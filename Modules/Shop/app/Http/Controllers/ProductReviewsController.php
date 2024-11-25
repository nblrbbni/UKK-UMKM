<?php

namespace Modules\Shop\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Shop\Models\Orders;
use App\Http\Controllers\Controller;
use Modules\Shop\Models\ProductReviews;

class ProductReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('shop::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($orderId)
    {
        $order = Orders::with('order_details.products')->findOrFail($orderId);

        return view('themes.umkm.reviews.create', compact('order'));
    }

    public function store(Request $request)
    {
        $customer = auth('web')->user();

        if (!$customer) {
            return redirect()->route('login')->with('error', 'You need to log in to submit reviews.');
        }

        $request->validate([
            'reviews' => 'required|array',
            'reviews.*.product_id' => 'required|exists:products,id',
            'reviews.*.rating' => 'required|integer|min:1|max:5',
            'reviews.*.comment' => 'nullable|string|max:500',
        ]);

        foreach ($request->reviews as $review) {
            ProductReviews::updateOrCreate(
                [
                    'customer_id' => $customer->id,
                    'product_id' => $review['product_id'],
                ],
                [
                    'rating' => $review['rating'],
                    'comment' => $review['comment'] ?? '',
                ]
            );
        }

        return redirect()->route('shop.index')->with('success', 'Thank you for your reviews!');
    }


    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('shop::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('shop::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
