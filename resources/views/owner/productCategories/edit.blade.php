@extends('layouts.owner.app')

@section('title')
Product Categories
@endsection

@section('title-2')
Edit Product Category
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('owner.productCategories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="category_name" class="form-label">Category Name</label>
                        <input type="text" class="form-control @error('category_name') is-invalid @enderror" id="category_name" name="category_name" value="{{ old('category_name', $category->category_name) }}" placeholder="Enter new category name">
                        @error('category_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" placeholder="Enter new slug">
                        @error('slug')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image_url" class="form-label">Upload New Image (Optional)</label>
                        <input type="file" class="form-control @error('image_url') is-invalid @enderror" id="image_url" name="image_url" accept="image/*" onchange="previewImage(event)">
                        <small class="text-muted">Upload new category image here</small>
                        @error('image_url')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image_preview" class="form-label">Image Preview</label>
                        <div>
                            <img id="image_preview" src="{{ $category->image_url ? asset($category->image_url) : 'path/default-image.png' }}" alt="Image Preview" style=" max-width: 200px; max-height: 200px;" class="border rounded">
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="text-end mt-4">
                        <a href="{{ route('owner.productCategories.index') }}" class="btn btn-outline-secondary me-2">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Cancel</span>
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Edit Category</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('image_preview');
            output.src = reader.result;
            output.style.display = 'block'; // Menampilkan preview gambar
        };
        reader.readAsDataURL(event.target.files[0]);
    }

</script>
@endsection
