<?php

namespace Modules\Shop\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Modules\Shop\Models\Products;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\Shop\Models\ProductCategories;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::with('product_category')->get();

        return view('owner.products.index', compact('products'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProductCategories::all();

        return view('owner.products.create', compact('categories'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_category_id' => 'required|exists:product_categories,id',
            'product_name' => 'required|unique:products|max:100',
            'slug' => 'nullable|unique:products|max:255',
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

        $imagePaths = [];
        for ($i = 1; $i <= 5; $i++) {
            $imageField = "image{$i}_url";
            $imagePaths[$imageField] = null;
            if ($request->hasFile($imageField)) {
                $imagePaths[$imageField] = $request->file($imageField)->store('products', 'public');
            }
        }

        Products::create([
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

        return redirect()->route('owner.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show($categorySlug, $productSlug)
    {
        $product = Products::with(['product_reviews.customers', 'product_category'])
            ->where('slug', $productSlug)
            ->firstOrFail();

        return view('themes.umkm.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Products::findOrFail($id);
        $categories = ProductCategories::all();

        return view('owner.products.edit', compact('product', 'categories'));
    }


    /**
     * Update the specified resource in storage.
     */
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

        $imagePaths = [];
        for ($i = 1; $i <= 5; $i++) {
            $imageField = "image{$i}_url";

            if ($request->hasFile($imageField)) {
                $currentImagePath = str_replace('storage/', '', $product->$imageField);
                if ($product->$imageField && Storage::disk('public')->exists($currentImagePath)) {
                    Storage::disk('public')->delete($currentImagePath);
                }
                $imagePaths[$imageField] = 'storage/' . $request->file($imageField)->store('products', 'public');
            } else {
                $imagePaths[$imageField] = $product->$imageField;
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
            'image1_url' => $imagePaths['image1_url'],
            'image2_url' => $imagePaths['image2_url'],
            'image3_url' => $imagePaths['image3_url'],
            'image4_url' => $imagePaths['image4_url'],
            'image5_url' => $imagePaths['image5_url'],
        ]);

        return redirect()->route('owner.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Products::findOrFail($id);

        for ($i = 1; $i <= 5; $i++) {
            $imageField = "image{$i}_url";
            if ($product->$imageField) {
                $filePath = str_replace('storage/', '', $product->$imageField);
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }
        }

        $product->delete();

        return redirect()->route('owner.products.index')->with('success', 'Product deleted successfully.');
    }
}
