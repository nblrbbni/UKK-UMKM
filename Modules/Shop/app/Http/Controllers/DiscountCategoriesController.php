<?php

namespace Modules\Shop\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Shop\Models\DiscountCategories;

class DiscountCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = DiscountCategories::all();

        return view('owner.discountCategories.index', compact('categories'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('owner.discountCategories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:discount_categories|max:100',
        ]);

        DiscountCategories::create([
            'category_name' => $request->category_name,
        ]);

        return redirect()->route('owner.discountCategories.index')->with('success', 'Discount Category created successfully.');
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
        $category = DiscountCategories::findOrFail($id);

        return view('owner.discountCategories.edit', compact('category'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|unique:discount_categories,category_name,' . $id . '|max:100',
        ]);

        $category = DiscountCategories::findOrFail($id);

        $category->update([
            'category_name' => $request->category_name,
        ]);

        return redirect()->route('owner.discountCategories.index')->with('success', 'Discount Category updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = DiscountCategories::findOrFail($id);

        if ($category->discounts()->count() > 0) {
            return redirect()->route('owner.discountCategories.index')
                ->with('error', 'Cannot delete category because it has related discounts.');
        }

        $category->delete();

        return redirect()->route('owner.discountCategories.index')->with('success', 'Discount Category deleted successfully.');
    }
}
