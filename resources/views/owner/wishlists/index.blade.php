@extends('layouts.owner.app')

@section('title')
    Shop
@endsection

@section('title-2')
    Wishlists
@endsection

@section('content')
    <!-- Wishlists Table -->
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Customer Wishlists</h5>
        </div>
        <div class="table-responsive text-nowrap">
            @if ($wishlists->isEmpty())
                <!-- Jika data kosong -->
                <div class="text-center my-5">
                    <h5>No Wishlists Found</h5>
                    <p>There are no wishlists available at the moment.</p>
                </div>
            @else
                <!-- Jika ada data -->
                <table class="table">
                    <thead>
                        <tr class="text-nowrap">
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>Customer Email</th>
                            <th>Product Name</th>
                            <th>Product Price</th>
                            <th>Product Image</th>
                            <th>Added At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($wishlists as $wishlist)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $wishlist->customers->name ?? 'N/A' }}</td>
                                <td>{{ $wishlist->customers->email ?? 'N/A' }}</td>
                                <td>{{ $wishlist->products->product_name ?? 'N/A' }}</td>
                                <td>Rp{{ number_format($wishlist->products->price ?? 0, 0, ',', '.') }}</td>
                                <td>
                                    @if ($wishlist->products->image1_url)
                                        <img src="{{ asset($wishlist->products->image1_url) }}" alt="Product Image"
                                            style="max-width: 100px; max-height: 50px;">
                                    @else
                                        Null
                                    @endif
                                </td>
                                <td>{{ $wishlist->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    <!--/ Wishlists Table -->
@endsection
