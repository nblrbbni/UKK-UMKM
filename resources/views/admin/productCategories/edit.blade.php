@extends('layouts.app')

@section('title')
    Edit Product Category
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('owner.productCategories.update', $category->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="category_name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="category_name" name="category_name"
                                value="{{ old('category_name', $category->category_name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug"
                                value="{{ old('slug', $category->slug) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="image_url" class="form-label">Upload New Image (Optional)</label>
                            <input type="file" class="form-control" id="image_url" name="image_url" accept="image/*"
                                onchange="previewImage(event)">
                            @if ($errors->has('image_url'))
                                <div class="alert alert-danger mt-2 text-danger">
                                    {{ $errors->first('image_url') }}
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="image_preview" class="form-label">Image Preview</label>
                            <!-- Tampilkan preview gambar baru jika diupload, atau gambar lama jika tidak diupload -->
                            <img id="image_preview" src="{{ old('image_url', asset($category->image_url)) }}"
                                alt="Image Preview"
                                style="max-width: 100%; max-height: 150px; display: {{ old('image_url') ? 'block' : 'none' }};">
                        </div>

                        <div class="text-end">
                            <a href="{{ route('owner.productCategories.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update</button>
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
