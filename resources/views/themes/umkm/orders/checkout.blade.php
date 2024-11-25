<!-- checkout.blade.php -->
@extends('themes.umkm.layouts.app')

@section('breadcrumb-title')
    Checkout
@endsection

@section('breadcrumb-links')
    <a href="{{ url('/') }}">Home</a>
    <a href="{{ url('/shopping-cart') }}">Shopping Cart</a>
    <span>Checkout</span>
@endsection

@section('content')
    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="checkout__form">
                <h4>Billing Details</h4>
                <form method="POST" action="{{ route('orders.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <div class="checkout__input">
                                <p>Name<span>*</span></p>
                                <input type="text" style="color: black;" name="name" value="{{ $customer->name }}"
                                    required>
                            </div>
                            <div class="checkout__input">
                                <p>Province<span>*</span></p>
                                <input type="text" style="color: black;" name="province"
                                    value="{{ $customer->address1 }}" required>
                            </div>
                            <div class="checkout__input">
                                <p>Town/City<span>*</span></p>
                                <input type="text" style="color: black;" name="town" value="{{ $customer->address2 }}"
                                    required>
                            </div>
                            <div class="checkout__input">
                                <p>District<span>*</span></p>
                                <input type="text" style="color: black;" name="district"
                                    value="{{ $customer->address3 }}" required>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Phone<span>*</span></p>
                                        <input type="text" name="phone" style="color: black;"
                                            value="{{ $customer->phone }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Email<span>*</span></p>
                                        <input type="email" name="email" style="color: black;"
                                            value="{{ $customer->email }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h4>Your Order</h4>
                                <div class="checkout__order__products">Products <span>Price</span></div>
                                @php
                                    $subtotal = 0;
                                @endphp
                                <ul>
                                    @foreach ($orders->order_details as $order)
                                        @php
                                            // Mengambil harga dengan mempertimbangkan diskon
                                            $price = $order->products->has_discount
                                                ? $order->products->discounted_price
                                                : $order->products->price;

                                            $itemTotal = $price * $order->quantity;
                                            $subtotal += $itemTotal;
                                        @endphp
                                        <li>
                                            {{ explode(' ', $order->products->product_name)[0] }} ({{ $order->quantity }})
                                            <span>Rp{{ number_format($itemTotal, 0, ',', '.') }}</span>
                                        </li>
                                    @endforeach
                                </ul>

                                @php
                                    $shipping_fee = $subtotal >= 300000 ? 0 : 20000;
                                    $final_total = $subtotal + $shipping_fee;
                                @endphp

                                <div class="checkout__order__products">SubTotal
                                    <span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>

                                <div class="checkout__order__subtotal">Shipping Fee
                                    @if ($shipping_fee == 0)
                                        <span>Free</span>
                                    @else
                                        <span>Rp{{ number_format($shipping_fee, 0, ',', '.') }}</span>
                                    @endif
                                </div>

                                <form method="POST" action="{{ route('orders.store') }}">
                                    @csrf
                                    <div class="checkout__order__total">Total Amount
                                        <span>Rp{{ number_format($final_total, 0, ',', '.') }}</span>
                                    </div>
                                    <input type="hidden" name="payment_method" value="Midtrans">
                                    <button type="submit" class="site-btn">PLACE ORDER</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->
@endsection
