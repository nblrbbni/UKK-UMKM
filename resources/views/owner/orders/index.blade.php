@extends('layouts.owner.app')

@section('title')
    Shop
@endsection

@section('title-2')
    Orders
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Orders</h5>
            <div class="d-flex align-items-center">
                <form action="{{ route('owner.orders.index') }}" method="GET" class="me-2">
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="cart">Cart</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </form>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            @if ($orders->isEmpty())
                <div class="text-center my-5">
                    <h5>No Orders Found</h5>
                    <p>There are no orders available at the moment.</p>
                </div>
            @else
                <table class="table">
                    <thead>
                        <tr class="text-nowrap">
                            <th>#</th>
                            <th>Order Date</th>
                            <th>Customer</th>
                            <th>Total Items</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y H:i') }}</td>
                                <td>{{ $order->customers->name ?? 'Unknown Customer' }}</td>
                                <td>{{ $order->order_details->sum('quantity') }}</td>
                                <td>Rp {{ $order->total_amount }}</td>
                                <td>
                                    <span
                                        class="badge
                            @switch($order->status)
                                @case('pending') bg-warning @break
                                @case('processing') bg-info @break
                                @case('completed') bg-success @break
                                @case('cancelled') bg-danger @break
                                @default bg-secondary
                            @endswitch
                        ">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('owner.orders.show', $order->id) }}" class="btn btn-primary btn-sm">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="card-footer">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
