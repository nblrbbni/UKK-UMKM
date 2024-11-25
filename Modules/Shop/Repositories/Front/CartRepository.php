<?php

namespace Modules\Shop\Repositories\Front;

use Illuminate\Support\Facades\DB;
use Modules\Shop\Models\Orders;
use Modules\Shop\Models\Customers;
use Modules\Shop\Models\OrderDetails;
use Modules\Shop\Models\Products;
use Modules\Shop\Repositories\Front\Interfaces\CartRepositoryInterface;

class CartRepository implements CartRepositoryInterface
{
    public function findByCustomer(Customers $customer): ?Orders
    {
        return Orders::with(['order_details', 'order_details.products'])
            ->forCustomer($customer)
            ->withStatus('cart')
            ->first();
    }

    public function addProductToCart(Customers $customer, Products $product, $quantity): OrderDetails
    {
        $order = $this->findOrCreateOrder($customer);

        $price = $product->hasDiscount ? $product->discounted_price : $product->price;

        $existOrderDetail = OrderDetails::where([
            'order_id' => $order->id,
            'product_id' => $product->id,
        ])->first();

        if (!$existOrderDetail) {
            $orderDetail = OrderDetails::create([
                'product_id' => $product->id,
                'order_id' => $order->id,
                'quantity' => $quantity,
                'subtotal' => $price * $quantity,
            ]);
        } else {
            $newQuantity = $existOrderDetail->quantity + $quantity;
            $existOrderDetail->update([
                'quantity' => $newQuantity,
                'subtotal' => $price * $newQuantity,
            ]);
            $orderDetail = $existOrderDetail;
        }

        $this->updateOrderTotalAmount($order);

        return $orderDetail;
    }

    public function updateOrderTotalAmount(Orders $order): void
    {
        $totalAmount = 0;

        foreach ($order->order_details as $detail) {
            $totalAmount += $detail->getRawOriginal('subtotal') ?? 0;
        }

        $order->update([
            'total_amount' => $totalAmount,
        ]);
    }

    public function removeItem($id): bool
    {
        try {
            DB::beginTransaction();

            $orderDetail = OrderDetails::findOrFail($id);
            $order = $orderDetail->orders;

            $orderDetail->delete();

            $remainingTotal = OrderDetails::where('order_id', $order->id)->sum('subtotal');
            $order->update([
                'total_amount' => $remainingTotal,
            ]);

            $remainingOrderDetails = OrderDetails::where('order_id', $order->id)->count();

            if ($remainingOrderDetails === 0) {
                $order->delete();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error removing cart item: ' . $e->getMessage());
            return false;
        }
    }

    public function updateQuantity(array $orderQuantities): void
    {
        foreach ($orderQuantities as $orderDetailID => $newQuantity) {
            $orderDetail = OrderDetails::find($orderDetailID);

            if ($orderDetail) {
                $price = $orderDetail->products->hasDiscount ? $orderDetail->products->discounted_price : $orderDetail->products->price;
                $orderDetail->quantity = $newQuantity;
                $orderDetail->subtotal = $price * $newQuantity;
                $orderDetail->save();
            }
        }

        $firstOrderDetail = OrderDetails::find(array_key_first($orderQuantities));
        if ($firstOrderDetail) {
            $order = $firstOrderDetail->orders;
            $this->updateOrderTotalAmount($order);
        }
    }

    private function findOrCreateOrder(Customers $customer)
    {
        $order = Orders::where('customer_id', $customer->id)
            ->where('status', 'cart')
            ->first();

        if (!$order) {
            $order = Orders::create([
                'customer_id' => $customer->id,
                'order_date' => now(),
                'total_amount' => 0,
                'status' => 'cart',
            ]);
        }

        return $order;
    }
}
