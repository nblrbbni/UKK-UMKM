<?php

namespace Modules\Shop\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Shop\Models\Orders;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch orders with related customer, paginated
        $orders = Orders::with('customers', 'order_details')
            ->latest('order_date')
            ->paginate(10);

        return view('owner.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('shop::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        // Fetch the order with all related details
        $order = Orders::with([
            'customers',
            'order_details.products', // Include products in order details
            'payments',
            'deliveries'
        ])->findOrFail($id);

        // Calculate total items and total subtotal
        $totalItems = $order->order_details->sum('quantity');
        $totalSubtotal = $order->order_details->sum(function ($detail) {
            return $detail->getRawSubtotal();
        });

        return view('owner.orders.show', compact('order', 'totalItems', 'totalSubtotal'));
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
