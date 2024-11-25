@extends('themes.umkm.layouts.app')

@section('breadcrumb-title')
    My Orders
@endsection

@section('breadcrumb-links')
    <a href="{{ url('/') }}">Home</a>
    <span>Orders</span>
@endsection

@section('content')
    <section class="shoping-cart spad">
        <div class="container">
            @if ($orders->count() > 0)
                <div class="row">
                    @include('themes.umkm.partial.flash')
                    <div class="col-lg-12">
                        <div class="shoping__cart__table">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="shoping__product">Order ID</th>
                                        <th>Date</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->order_date }}</td>
                                            <td>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                            <td>{{ ucfirst($order->status) }}</td>
                                            <td>
                                                <a href="{{ route('orders.show', $order->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    View Details
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h3 class="mb-3">You have no orders yet.</h3>
                        <a href="{{ url('/shop') }}" class="primary-btn">Shop Now</a>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
