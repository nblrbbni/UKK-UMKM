@extends('themes.umkm.layouts.app')

@section('breadcrumb-title')
    Shopping Cart
@endsection

@section('breadcrumb-links')
    <a href="{{ url('/') }}">Home</a>
    <span>Shopping Cart</span>
@endsection

@section('content')
    <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            @if ($orders && $orders->order_details->count() > 0)
                <div class="row">
                    <div class="col-lg-12">
                        {{ html()->form('PUT', route('carts.update'))->class('update-cart-form')->open() }}
                        <div class="shoping__cart__table">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="shoping__product">Products</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Sub Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders->order_details as $order)
                                        <tr>
                                            <td class="shoping__cart__item">
                                                <img src="{{ $order->products->image1_url }}" height="100px" alt="">
                                                <h5>{{ $order->products->product_name }}</h5>
                                            </td>
                                            <td class="shoping__cart__price">
                                                @if ($order->products->has_discount)
                                                    <span
                                                        style="text-decoration: line-through; color: #888;">Rp{{ $order->products->price_label }}</span>
                                                    <br>
                                                    Rp{{ $order->products->discounted_price_label }}
                                                @else
                                                    Rp{{ $order->products->price_label }}
                                                @endif
                                            </td>
                                            <td class="shoping__cart__quantity">
                                                <div class="quantity">
                                                    <div class="pro-qty">
                                                        <input type="number" value="{{ $order->quantity }}"
                                                            name="quantity[{{ $order->id }}]" min="1">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="shoping__cart__total">
                                                Rp{{ $order->subtotal }}
                                            </td>
                                            <td class="shoping__cart__item__close">
                                                <a href="{{ route('carts.destroy', $order->id) }}"
                                                    class="btn btn-danger btn-sm delete-item" data-method="delete"
                                                    data-token="{{ csrf_token() }}"
                                                    data-confirm="Are you sure you want to delete this item?">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="shoping__cart__btns">
                            <a href="{{ route('shop.index') }}" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                            <button type="submit" class="primary-btn cart-btn cart-btn-right" style="border: none;">
                                <span class="icon_loading"></span> Update Cart
                            </button>
                        </div>
                        {{ html()->form()->close() }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6"></div>
                    <div class="col-lg-6">
                        <div class="shoping__checkout">
                            <h5>Cart Total</h5>
                            <ul>
                                <li>Total Amount <span>Rp{{ $orders->total_amount }}</span></li>
                            </ul>
                            <a href="{{ route('orders.checkout') }}" class="primary-btn">PROCEED TO CHECKOUT</a>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h3 class="mb-3">You haven't added any products to the cart yet.</h3>
                        <a href="{{ url('/shop') }}" class="primary-btn">Show Now</a>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
