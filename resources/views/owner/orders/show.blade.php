@extends('layouts.owner.app')

@section('title')
    Orders
@endsection

@section('title-2')
    Order Details
@endsection

@section('content')
    <div class="row">
        <!-- Basic Order Information -->
        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">Order Information</h5>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Order ID</th>
                            <td>{{ $order->id }}</td>
                        </tr>
                        <tr>
                            <th>Customer</th>
                            <td>{{ $order->customers->name }}</td>
                        </tr>
                        <tr>
                            <th>Order Date</th>
                            <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">Order Summary</h5>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Total Items</th>
                            <td>{{ $totalItems }}</td>
                        </tr>
                        <tr>
                            <th>Total Amount</th>
                            <td>Rp {{ $order->total_amount }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span
                                    class="badge
                                @switch($order->status)
                                    @case('cart') bg-secondary @break
                                    @case('pending') bg-warning @break
                                    @case('processing') bg-info @break
                                    @case('completed') bg-success @break
                                    @case('cancelled') bg-danger @break
                                @endswitch
                            ">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Order Items</h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->order_details as $detail)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $detail->products->product_name }}</td>
                                        <td>{{ $detail->quantity }}</td>
                                        <td>Rp {{ number_format($detail->products->price, 0, ',', '.') }}</td>
                                        <td>Rp {{ $detail->subtotal }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row mt-4">
        <div class="col-md-12">
            <a href="{{ route('owner.orders.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
@endsection
