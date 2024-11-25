@extends('themes.umkm.layouts.app')

@section('breadcrumb-title')
    Order Details
@endsection

@section('breadcrumb-links')
    <a href="{{ url('/') }}">Home</a>
    <a href="{{ route('orders.index') }}">Orders</a>
    <span>Order Details</span>
@endsection

@section('content')
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                @include('themes.umkm.partial.flash')
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <h5>Order #{{ $order->id }}</h5>
                        <p>Date: {{ $order->order_date }}</p>
                        <p>Status: {{ ucfirst($order->status) }}</p>
                        <p>Total: Rp{{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        <hr>
                        <table>
                            <thead>
                                <tr>
                                    <th class="shoping__product">Products</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->order_details as $detail)
                                    <tr>
                                        <td class="shoping__cart__item">
                                            <img src="{{ $detail->products->image1_url }}" height="100px" alt="">
                                            <h5>{{ $detail->products->product_name }}</h5>
                                        </td>
                                        <td>{{ $detail->quantity }}</td>
                                        <td>Rp{{ $detail->subtotal }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <hr>
                        <div class="text-end">
                            <a href="{{ url('/shop') }}" class="primary-btn">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
