@extends('layouts.owner.app')

@section('title')
Categories
@endsection

@section('title-2')
Product Categories
@endsection

@section('content')
<!-- Product Categories Table -->
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Product Categories</h5>
        <a href="{{ route('owner.productCategories.create') }}" class="btn btn-primary float-end">
            Add New Product Category
        </a>
    </div>
    <div class="table-responsive text-nowrap">
        @if ($categories->isEmpty())
        <!-- Jika data kosong -->
        <div class="text-center my-5">
            <h5>No Product Categories Found</h5>
            <p>There are no product categories available. Click the button below to add one.</p>
            <a href="{{ route('owner.productCategories.create') }}" class="btn btn-primary">
                Add Product Category
            </a>
        </div>
        @else
        <!-- Jika ada data -->
        <table class="table">
            <thead>
                <tr class="text-nowrap">
                    <th>#</th>
                    <th>Category Name</th>
                    <th>Slug</th>
                    <th>Image</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $category->category_name }}</td>
                    <td>{{ $category->slug }}</td>
                    <td>
                        @if ($category->image_url)
                        <img src="{{ asset($category->image_url) }}" alt="Category Image" style="max-width: 100px; max-height: 50px;">
                        @else
                        No image available
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('owner.productCategories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('owner.productCategories.destroy', $category->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
<!--/ Product Categories Table -->
@endsection
