<?php

namespace Modules\Shop\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Shop\Models\Products;
use Modules\Shop\Models\Discounts;
use App\Http\Controllers\Controller;
use Modules\Shop\Models\DiscountCategories;

class DiscountsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discounts = Discounts::with(['discount_categories', 'product'])->get();

        return view('owner.discounts.index', compact('discounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = DiscountCategories::all();
        $products = Products::all();

        return view('owner.discounts.create', compact('categories', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_discount_id' => 'required|exists:discount_categories,id',
            'product_id' => 'required|exists:products,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'percentage' => 'required|integer|min:1|max:100',
        ]);

        Discounts::create($request->all());

        return redirect()->route('owner.discounts.index')->with('success', 'Discount created successfully.');
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
        $discount = Discounts::with(['discount_categories', 'product'])->findOrFail($id);
        $categories = DiscountCategories::all(); // Get all discount categories
        $products = Products::all(); // Get all products

        return view('owner.discounts.edit', compact('discount', 'categories', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_discount_id' => 'required|exists:discount_categories,id',
            'product_id' => 'required|exists:products,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'percentage' => 'required|integer|min:1|max:100',
        ]);

        $discount = Discounts::findOrFail($id);
        $discount->update($request->all());

        return redirect()->route('owner.discounts.index')->with('success', 'Discount updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $discount = Discounts::findOrFail($id);
        $discount->delete();

        return redirect()->route('owner.discounts.index')->with('success', 'Discount deleted successfully.');
    }
}
