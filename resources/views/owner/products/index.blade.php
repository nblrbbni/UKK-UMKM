@extends('layouts.owner.app')

@section('title')
    Shop
@endsection

@section('title-2')
    Products
@endsection

@section('content')
    <!-- Products Table -->
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Products</h5>
            <a href="{{ route('owner.products.create') }}" class="btn btn-primary float-end">
                Add New Product
            </a>
        </div>
        <div class="table-responsive text-nowrap">
            @if ($products->isEmpty())
                <!-- Jika data kosong -->
                <div class="text-center my-5">
                    <h5>No Products Found</h5>
                    <p>There are no products available. Click the button below to add one.</p>
                    <a href="{{ route('owner.products.create') }}" class="btn btn-primary">
                        Add Product
                    </a>
                </div>
            @else
                <!-- Jika ada data -->
                <table class="table">
                    <thead>
                        <tr class="text-nowrap">
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock Quantity</th>
                            <th>Weight</th>
                            <th>Image 1</th>
                            <th>Image 2</th>
                            <th>Image 3</th>
                            <th>Image 4</th>
                            <th>Image 5</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->slug }}</td>
                                <td>
                                    @if (str_word_count($product->description) > 5)
                                        {{ implode(' ', array_slice(explode(' ', $product->description), 0, 5)) }}...
                                    @else
                                        {{ $product->description }}
                                    @endif
                                </td>
                                <td>{{ $product->product_category->category_name ?? '-' }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->stok_quantity }}</td>
                                <td>{{ $product->weight }}</td>
                                <td>
                                    @if ($product->image1_url)
                                        <img src="{{ asset($product->image1_url) }}" alt="Product Image 1"
                                            style="max-width: 100px; max-height: 50px;">
                                    @else
                                        Null
                                    @endif
                                </td>
                                <td>
                                    @if ($product->image2_url)
                                        <img src="{{ asset($product->image2_url) }}" alt="Product Image 2"
                                            style="max-width: 100px; max-height: 50px;">
                                    @else
                                        Null
                                    @endif
                                </td>
                                <td>
                                    @if ($product->image3_url)
                                        <img src="{{ asset($product->image3_url) }}" alt="Product Image 3"
                                            style="max-width: 100px; max-height: 50px;">
                                    @else
                                        Null
                                    @endif
                                </td>
                                <td>
                                    @if ($product->image4_url)
                                        <img src="{{ asset($product->image4_url) }}" alt="Product Image 4"
                                            style="max-width: 100px; max-height: 50px;">
                                    @else
                                        Null
                                    @endif
                                </td>
                                <td>
                                    @if ($product->image5_url)
                                        <img src="{{ asset($product->image5_url) }}" alt="Product Image 5"
                                            style="max-width: 100px; max-height: 50px;">
                                    @else
                                        Null
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('owner.products.edit', $product->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('owner.products.destroy', $product->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this product?')">
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
    <!--/ Products Table -->
@endsection
