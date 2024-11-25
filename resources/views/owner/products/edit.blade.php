@extends('layouts.owner.app')

@section('title')
    Edit Product
@endsection

@section('title-2')
    Edit Product
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <h5 class="card-header">Edit Product</h5>
                <div class="card-body">
                    <form action="{{ route('owner.products.update', $product->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="product_category_id" class="form-label">Product Category</label>
                            <select class="form-control @error('product_category_id') is-invalid @enderror"
                                id="product_category_id" name="product_category_id">
                                <option value="" disabled>Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $product->product_category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="product_name" class="form-label">Product Name</label>
                            <input type="text" class="form-control @error('product_name') is-invalid @enderror"
                                id="product_name" name="product_name"
                                value="{{ old('product_name', $product->product_name) }}" />
                            @error('product_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                                name="slug" value="{{ old('slug', $product->slug) }}" />
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="3">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                                name="price" value="{{ old('price', $product->price) }}" />
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="stok_quantity" class="form-label">Stock Quantity</label>
                            <input type="number" class="form-control @error('stok_quantity') is-invalid @enderror"
                                id="stok_quantity" name="stok_quantity"
                                value="{{ old('stok_quantity', $product->stok_quantity) }}" />
                            @error('stok_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="weight" class="form-label">Weight</label>
                            <input type="text" class="form-control @error('weight') is-invalid @enderror" id="weight"
                                name="weight" value="{{ old('weight', $product->weight) }}" />
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @for ($i = 1; $i <= 5; $i++)
                            <div class="mb-3">
                                <label for="image{{ $i }}_url" class="form-label">Image
                                    {{ $i }}</label>
                                <input class="form-control @error('image' . $i . '_url') is-invalid @enderror"
                                    type="file" id="image{{ $i }}_url" name="image{{ $i }}_url"
                                    accept="image/*" />
                                <div class="mt-2">
                                    @if ($product->{'image' . $i . '_url'})
                                        <img src="{{ asset($product->{'image' . $i . '_url'}) }}"
                                            alt="Image {{ $i }}" style="max-width: 100%; max-height: 100px;"
                                            class="border rounded">
                                    @else
                                        <p>No image available</p>
                                    @endif
                                </div>
                                @error('image' . $i . '_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endfor

                        <hr class="my-4">

                        <div class="text-end">
                            <a href="{{ route('owner.products.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
