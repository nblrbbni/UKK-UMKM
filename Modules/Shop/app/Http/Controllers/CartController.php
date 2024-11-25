<?php

namespace Modules\Shop\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Shop\Models\Orders;

use Modules\Shop\Models\Products;
use Modules\Shop\Models\Wishlists;

use App\Http\Controllers\Controller;
use Modules\Shop\Models\OrderDetails;
use Modules\Shop\Repositories\Front\Interfaces\CartRepositoryInterface;
use Modules\Shop\Repositories\Front\Interfaces\ProductRepositoryInterface;

class CartController extends Controller
{
    protected $cartRepository;
    protected $productRepository;

    public function __construct(CartRepositoryInterface $cartRepository, ProductRepositoryInterface $productRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;

        $this->middleware('auth:web');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customer = auth('web')->user();

        $orders = $this->cartRepository->findByCustomer($customer);

        if (!$orders) {
            $this->data['orders'] = null;
        } else {
            $this->data['orders'] = $orders;
        }

        return $this->loadTheme('cart.index', $this->data);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('shop::create');
    }

    public function store(Request $request)
    {
        $productID = $request->get('product_id');
        $quantity = $request->get('quantity');
        $product = $this->productRepository->findById($productID);
        $customer = auth('web')->user();

        if ($product->stock_status == 'Out of Stock') {
            return redirect(shop_product_link($product))->with('error', 'Product unavailable');
        }
        if ($product->stok_quantity < $quantity) {
            return redirect(shop_product_link($product))->with('error', 'Not enough stock');
        }

        $order = Orders::firstOrCreate(
            ['customer_id' => $customer->id, 'status' => 'cart'],
            [
                'order_date' => now(),
                'total_amount' => 0,
            ]
        );

        $price = $product->hasDiscount ? $product->discounted_price : $product->price;

        $orderDetail = OrderDetails::firstOrNew([
            'order_id' => $order->id,
            'product_id' => $product->id,
        ]);

        $orderDetail->quantity = $quantity;
        $orderDetail->subtotal = $price * $quantity;
        $orderDetail->save();

        $this->cartRepository->updateOrderTotalAmount($order);

        Wishlists::where('customer_id', $customer->id)
            ->where('product_id', $productID)
            ->delete();

        if ($request->headers->get('referer') && str_contains($request->headers->get('referer'), 'wishlists')) {
            return redirect()->route('wishlists.index')->with('success', 'Product successfully added to cart');
        }

        return redirect()->back()->with('success', 'Successfully added product to cart');
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
    public function update(Request $request)
    {
        $quantities = $request->input('quantity', []);

        $this->cartRepository->updateQuantity($quantities);

        $customer = auth('web')->user();
        $order = $this->cartRepository->findByCustomer($customer);

        $this->cartRepository->updateOrderTotalAmount($order);

        return redirect()->route('carts.index')->with('success', 'Quantity of products successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer = auth('web')->user();

        $orderDetail = OrderDetails::where('id', $id)
            ->whereHas('orders', function ($query) use ($customer) {
                $query->where('customer_id', $customer->id);
            })->first();

        if (!$orderDetail) {
            return redirect()->route('carts.index')->with('error', 'Product not found in cart');
        }

        try {
            $order = $orderDetail->orders;
            $orderDetail->delete();

            $this->cartRepository->updateOrderTotalAmount($order);

            if ($order->order_details->isEmpty()) {
                $order->delete();
                return redirect()->route('carts.index')->with('success', 'Product successfully removed from cart. Order has also been deleted as empty');
            }

            return redirect()->route('carts.index')->with('success', 'Product successfully removed from cart. Total amount has been updated');
        } catch (\Exception $e) {
            return redirect()->route('carts.index')->with('error', 'Failed to remove product from cart');
        }
    }
}
