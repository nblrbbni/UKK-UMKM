@extends('layouts.owner.app')

@section('title')
    Product Categories
@endsection

@section('title-2')
    Create New Product Category
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <h5 class="card-header">Create Product Category</h5>
                <div class="card-body">
                    <form action="{{ route('owner.productCategories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="category_name" class="form-label">Category Name</label>
                            <input type="text" class="form-control @error('category_name') is-invalid @enderror"
                                id="category_name" name="category_name" value="{{ old('category_name') }}"
                                placeholder="Enter category name" />
                            @error('category_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                                name="slug" value="{{ old('slug') }}" placeholder="Enter slug" />
                            @error('slug')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image_url" class="form-label">Category Image</label>
                            <input class="form-control @error('image_url') is-invalid @enderror" type="file"
                                id="image_url" name="image_url" accept="image/*" onchange="previewImage(event)" />
                            <small class="text-muted">Upload category image here</small>
                            @error('image_url')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image_preview" class="form-label">Image Preview</label>
                            <div>
                                <img id="image_preview" src="" alt="Image Preview"
                                    style="max-width: 200px; max-height: 200px; display: none;" class="border rounded" />
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
                                <span class="d-none d-sm-block">Create Category</span>
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
            const preview = document.getElementById('image_preview');

            reader.onload = function() {
                preview.src = reader.result;
                preview.style.display = 'block';
            }

            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        }
    </script>
@endsection
