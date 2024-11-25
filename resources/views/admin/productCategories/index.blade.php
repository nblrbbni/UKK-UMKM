@extends('layouts.app')

@section('title')
    Product Categories
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <a href="{{ route('owner.productCategories.create') }}" class="btn btn-primary mb-3">
                Add New Product Categories
            </a>
            <div class="card">
                <div class="card-body">
                    <!-- Table for displaying product categories -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category Name</th>
                                    <th>Slug</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $category->category_name }}</td>
                                        <td>{{ $category->slug }}</td>
                                        <td>
                                            @if ($category->image_url)
                                                <img src="{{ asset($category->image_url) }}" alt="Category Image"
                                                    style="max-width: 100px; max-height: 50px;">
                                            @else
                                                No image available
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('owner.productCategories.edit', $category->id) }}"
                                                class="btn btn-warning">Edit</a>

                                            <!-- Delete button -->
                                            <form action="{{ route('owner.productCategories.destroy', $category->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
