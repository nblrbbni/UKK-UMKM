@extends('layouts.owner.app')

@section('title')
    Shop
@endsection

@section('title-2')
    Discounts
@endsection

@section('content')
    <!-- Discounts Table -->
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Discounts</h5>
            <a href="{{ route('owner.discounts.create') }}" class="btn btn-primary float-end">
                Add New Discount
            </a>
        </div>
        <div class="table-responsive text-nowrap">
            @if ($discounts->isEmpty())
                <!-- Jika data kosong -->
                <div class="text-center my-5">
                    <h5>No Discounts Found</h5>
                    <p>There are no discounts available. Click the button below to add one.</p>
                    <a href="{{ route('owner.discounts.create') }}" class="btn btn-primary">
                        Add Discount
                    </a>
                </div>
            @else
                <!-- Jika ada data -->
                <table class="table">
                    <thead>
                        <tr class="text-nowrap">
                            <th>#</th>
                            <th>Category</th>
                            <th>Product</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Percentage</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($discounts as $discount)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $discount->discount_categories->category_name ?? '-' }}</td>
                                <td>{{ $discount->product->product_name ?? '-' }}</td>
                                <td>{{ $discount->start_date }}</td>
                                <td>{{ $discount->end_date }}</td>
                                <td>{{ $discount->percentage }}%</td>
                                <td class="text-end">
                                    <a href="{{ route('owner.discounts.edit', $discount->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('owner.discounts.destroy', $discount->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this discount?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    <!--/ Discounts Table -->
@endsection
