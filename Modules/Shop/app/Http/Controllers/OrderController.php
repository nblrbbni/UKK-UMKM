<?php

namespace Modules\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Shop\Models\Orders;
use Modules\Shop\Models\Deliveries;
use Modules\Shop\Models\Payments;
use Modules\Shop\Models\Customers;
use Modules\Shop\Repositories\Front\Interfaces\CartRepositoryInterface;

class OrderController extends Controller
{
    protected $cartRepository;

    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;

        $this->middleware('auth:web');
    }

    public function index()
    {
        $customer = auth('web')->user();
        $orders = Orders::where('customer_id', $customer->id)
            ->with('order_details.products')
            ->get();

        $this->data['orders'] = $orders;

        return $this->loadTheme('orders.index', $this->data);
    }

    public function show($id)
    {
        $customer = auth('web')->user();
        $order = Orders::where('id', $id)
            ->where('customer_id', $customer->id)
            ->with('order_details.products')
            ->firstOrFail();

        $this->data['order'] = $order;

        return $this->loadTheme('orders.show', $this->data);
    }


    public function checkout()
    {
        $customer = auth('web')->user();

        $this->data['orders'] = $this->cartRepository->findByCustomer($customer);
        $this->data['customer'] = $customer;

        return $this->loadTheme('orders.checkout', $this->data);
    }

    public function store(Request $request)
    {
        $customer = auth('web')->user();

        $order = $this->cartRepository->findByCustomer($customer);

        if (!$order) {
            return redirect()->back()->withErrors('Cart is empty!');
        }

        $order->deliveries()->delete();
        $order->payments()->delete();
        $order->order_details()->delete();
        $order->delete();

        $newOrder = Orders::create([
            'customer_id' => $customer->id,
            'order_date' => now(),
            'total_amount' => 0,
            'status' => 'checkout',
        ]);

        $subtotal = $order->order_details->sum(function ($orderDetail) {
            $price = $orderDetail->products->has_discount
                ? $orderDetail->products->discounted_price
                : $orderDetail->products->price;

            return $price * $orderDetail->quantity;
        });

        $shippingFee = $subtotal >= 300000 ? 0 : 20000;
        $final_total = $subtotal + $shippingFee;

        foreach ($order->order_details as $orderDetail) {
            $newOrder->order_details()->create([
                'product_id' => $orderDetail->product_id,
                'quantity' => $orderDetail->quantity,
                'subtotal' => $orderDetail->subtotal,
            ]);
        }

        Payments::create([
            'order_id' => $newOrder->id,
            'payment_date' => now(),
            'payment_method' => $request->payment_method ?? 'Midtrans',
            'amount' => $final_total,
        ]);

        Deliveries::create([
            'order_id' => $newOrder->id,
            'shipping_date' => Deliveries::calculateShippingDate($newOrder->order_date),
            'tracking_code' => Deliveries::generateTrackingCode($newOrder),
            'status' => 'Pending',
        ]);

        return $this->initiateMidtransPayment($newOrder, $final_total);
    }

    private function initiateMidtransPayment($order, $amount)
    {
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;

        $params = [
            'transaction_details' => [
                'order_id' => $order->id,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => $order->customers->name,
                'email' => $order->customers->email,
                'phone' => $order->customers->phone,
            ],
        ];

        return redirect(\Midtrans\Snap::createTransaction($params)->redirect_url);
    }

    public function handleMidtransNotification(Request $request)
    {
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $notification = new \Midtrans\Notification();

        $transaction = $notification->transaction_status;
        $orderId = $notification->order_id;

        $order = Orders::with('order_details.products')->find($orderId);

        if (!$order) {
            \Log::error("Order not found: " . $orderId);
            return response()->json(['status' => 'Order not found'], 404);
        }

        if ($transaction == 'capture' || $transaction == 'settlement') {
            $order->status = 'Paid';
            $order->save();

            $delivery = $order->deliveries()->first();
            if ($delivery) {
                $delivery->status = 'Ready for Shipping';
                $delivery->save();
            }

            return redirect()->route('reviews.create', ['orderId' => $order->id]);
        } elseif ($transaction == 'pending') {
            $order->status = 'Pending';
            $order->save();
        } elseif ($transaction == 'deny' || $transaction == 'cancel' || $transaction == 'expire') {
            $order->status = 'Failed';
            $order->save();

            $delivery = $order->deliveries()->first();
            if ($delivery) {
                $delivery->status = 'Cancelled';
                $delivery->save();
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function handlePaymentFinish(Request $request)
    {
        $orderId = $request->query('order_id');
        $statusCode = $request->query('status_code');
        $transactionStatus = $request->query('transaction_status');

        if (!$orderId) {
            return redirect()->route('orders.checkout')->with('error', 'Invalid payment response.');
        }

        $order = Orders::with('order_details.products')->find($orderId);

        if (!$order) {
            return redirect()->route('orders.checkout')->with('error', 'Order not found.');
        }

        if ($transactionStatus === 'settlement' || $transactionStatus === 'capture') {
            $order->status = 'Paid';
            $order->save();

            return redirect()->route('reviews.create', ['orderId' => $orderId])
                ->with('success', 'Payment successful! Please review your purchased products.');
        } elseif ($transactionStatus === 'pending') {
            $order->status = 'Pending';
            $order->save();

            return redirect()->route('orders.checkout')->with('warning', 'Payment is pending.');
        } else {
            $order->status = 'Failed';
            $order->save();

            return redirect()->route('orders.checkout')->with('error', 'Payment failed.');
        }
    }
}
