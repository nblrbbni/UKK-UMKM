<?php

namespace Modules\Shop\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Shop\Models\Wishlists;
use Modules\Shop\Models\Products;

class WishlistsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    /**
     * Display the wishlist for the authenticated customer.
     */
    public function index()
    {
        $customer = auth('web')->user();
        $wishlists = Wishlists::where('customer_id', $customer->id)
            ->with('products')
            ->get();

        return $this->loadTheme('wishlists.index', compact('wishlists'));
    }

    /**
     * Add a product to the wishlist.
     */
    public function store(Request $request)
    {
        $customer = auth('web')->user();
        $productID = $request->get('product_id');

        $product = Products::find($productID);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found');
        }

        $existingWishlist = Wishlists::where('customer_id', $customer->id)
            ->where('product_id', $productID)
            ->first();

        if ($existingWishlist) {
            return redirect()->back()->with('error', 'Product already on wishlist');
        }

        Wishlists::create([
            'customer_id' => $customer->id,
            'product_id' => $productID,
        ]);

        return redirect()->back()->with('success', 'Product successfully added to wishlist');
    }

    /**
     * Remove a product from the wishlist.
     */
    public function destroy($id)
    {
        $customer = auth('web')->user();

        $wishlist = Wishlists::where('id', $id)
            ->where('customer_id', $customer->id)
            ->first();

        if (!$wishlist) {
            return redirect()->route('wishlists.index')
                ->with('error', 'Product not found on wishlist');
        }

        try {
            $wishlist->delete();
            return redirect()->route('wishlists.index')
                ->with('success', 'Product successfully removed from wishlist');
        } catch (\Exception $e) {
            return redirect()->route('wishlists.index')
                ->with('error', 'Failed to remove product from wishlist');
        }
    }
}
