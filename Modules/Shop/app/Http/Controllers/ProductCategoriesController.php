<?php

namespace Modules\Shop\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Modules\Shop\Models\Products;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\Shop\Models\ProductCategories;

class ProductCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ProductCategories::all();

        return view('owner.productCategories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('owner.productCategories.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:product_categories|max:255',
            'slug' => 'nullable|unique:product_categories|max:255',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $slug = $request->slug ?: Str::slug($request->category_name);

        $imagePath = null;

        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('product_categories', 'public');
        }

        ProductCategories::create([
            'category_name' => $request->category_name,
            'slug' => $slug,
            'image_url' => $imagePath ? 'storage/' . $imagePath : null,
        ]);

        return redirect()->route('owner.productCategories.index')->with('success', 'Category created successfully.');
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
        $category = ProductCategories::findOrFail($id);

        return view('owner.productCategories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $product = Products::findOrFail($id);

        $request->validate([
            'product_category_id' => 'required|exists:product_categories,id',
            'product_name' => 'required|max:100|unique:products,product_name,' . $product->id,
            'slug' => 'nullable|max:255|unique:products,slug,' . $product->id,
            'description' => 'nullable',
            'price' => 'required|integer|min:0',
            'stok_quantity' => 'required|integer|min:0',
            'weight' => 'required|max:50',
            'image1_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image3_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image4_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image5_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $slug = $request->slug ?: Str::slug($request->product_name);

        // Proses gambar
        $imagePaths = [];
        for ($i = 1; $i <= 5; $i++) {
            $imageField = "image{$i}_url";

            // Jika ada file baru, hapus gambar lama dan simpan yang baru
            if ($request->hasFile($imageField)) {
                $currentImagePath = str_replace('storage/', '', $product->$imageField);
                if ($product->$imageField && Storage::disk('public')->exists($currentImagePath)) {
                    Storage::disk('public')->delete($currentImagePath);
                }

                $imagePaths[$imageField] = $request->file($imageField)->store('products', 'public');
            } else {
                // Tetap gunakan gambar lama jika tidak ada file baru
                $imagePaths[$imageField] = str_replace('storage/', '', $product->$imageField);
            }
        }

        $product->update([
            'product_category_id' => $request->product_category_id,
            'product_name' => $request->product_name,
            'slug' => $slug,
            'description' => $request->description,
            'price' => $request->price,
            'stok_quantity' => $request->stok_quantity,
            'weight' => $request->weight,
            'image1_url' => $imagePaths['image1_url'] ? 'storage/' . $imagePaths['image1_url'] : null,
            'image2_url' => $imagePaths['image2_url'] ? 'storage/' . $imagePaths['image2_url'] : null,
            'image3_url' => $imagePaths['image3_url'] ? 'storage/' . $imagePaths['image3_url'] : null,
            'image4_url' => $imagePaths['image4_url'] ? 'storage/' . $imagePaths['image4_url'] : null,
            'image5_url' => $imagePaths['image5_url'] ? 'storage/' . $imagePaths['image5_url'] : null,
        ]);

        return redirect()->route('owner.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = ProductCategories::findOrFail($id);

        $currentImagePath = str_replace('storage/', '', $category->image_url);
        if ($category->image_url && Storage::disk('public')->exists($currentImagePath)) {
            Storage::disk('public')->delete($currentImagePath);
        }

        $category->delete();

        return redirect()->route('owner.productCategories.index')->with('success', 'Category deleted successfully.');
    }
}
