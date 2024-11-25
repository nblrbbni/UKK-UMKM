@extends('layouts.owner.app')

@section('title')
    Products
@endsection

@section('title-2')
    Create New Product
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <h5 class="card-header">Create Product</h5>
                <div class="card-body">
                    <form action="{{ route('owner.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="product_category_id" class="form-label">Product Category</label>
                            <select class="form-control @error('product_category_id') is-invalid @enderror"
                                id="product_category_id" name="product_category_id">
                                <option value="" disabled selected>Choose a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('product_category_id') == $category->id ? 'selected' : '' }}>
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
                                id="product_name" name="product_name" value="{{ old('product_name') }}"
                                placeholder="Enter product name" />
                            @error('product_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                                name="slug" value="{{ old('slug') }}" placeholder="Enter product name" />
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                                name="price" value="{{ old('price') }}" placeholder="Enter price" />
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="stok_quantity" class="form-label">Stock Quantity</label>
                            <input type="number" class="form-control @error('stok_quantity') is-invalid @enderror"
                                id="stok_quantity" name="stok_quantity" value="{{ old('stok_quantity') }}"
                                placeholder="Enter stock quantity" />
                            @error('stok_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="weight" class="form-label">Weight</label>
                            <input type="text" class="form-control @error('weight') is-invalid @enderror" id="weight"
                                name="weight" value="{{ old('weight') }}" placeholder="Enter weight" />
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
                                    accept="image/*" onchange="previewImage(event, {{ $i }})" />
                                @error('image' . $i . '_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="mt-2">
                                    <img id="image_preview_{{ $i }}" src=""
                                        alt="Image Preview {{ $i }}"
                                        style="max-width: 100%; max-height: 100px; display: none;" class="border rounded" />
                                </div>
                            </div>
                        @endfor

                        <hr class="my-4">

                        <div class="text-end mt-4">
                            <a href="{{ route('owner.products.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event, index) {
            const reader = new FileReader();
            const preview = document.getElementById(`image_preview_${index}`);

            reader.onload = function() {
                preview.src = reader.result;
                preview.style.display = 'block';
            };

            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        }
    </script>
@endsection
