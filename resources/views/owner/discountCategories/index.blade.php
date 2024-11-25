@extends('layouts.owner.app')

@section('title')
Categories
@endsection

@section('title-2')
Discount Categories
@endsection

@section('content')
<!-- Discount Categories Table -->
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Discount Categories</h5>
        <a href="{{ route('owner.discountCategories.create') }}" class="btn btn-primary float-end">
            Add New Discount Category
        </a>
    </div>
    <div class="table-responsive text-nowrap">
        @if ($categories->isEmpty())
        <!-- Jika data kosong -->
        <div class="text-center my-5">
            <h5>No Discount Categories Found</h5>
            <p>There are no discount categories available. Click the button below to add one.</p>
            <a href="{{ route('owner.discountCategories.create') }}" class="btn btn-primary">
                Add Discount Category
            </a>
        </div>
        @else
        <!-- Jika ada data -->
        <table class="table">
            <thead>
                <tr class="text-nowrap">
                    <th>#</th>
                    <th>Category Name</th>
                    <th class="text-end">Actions</th> <!-- Tambahkan 'text-end' pada kolom header -->
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $category->category_name }}</td>
                    <td class="text-end">
                        <a href="{{ route('owner.discountCategories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('owner.discountCategories.destroy', $category->id) }}" method="POST" style="display:inline;">
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
<!--/ Discount Categories Table -->
@endsection
