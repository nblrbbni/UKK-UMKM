@extends('layouts.owner.app')

@section('title')
Discount Categories
@endsection

@section('title-2')
Create New Discount Category
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <h5 class="card-header">Create Discount Category</h5>
            <div class="card-body">
                <form action="{{ route('owner.discountCategories.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="category_name" class="form-label">Category Name</label>
                        <input type="text" class="form-control @error('category_name') is-invalid @enderror" id="category_name" name="category_name" value="{{ old('category_name') }}" placeholder="Enter category name" />
                        @error('category_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <div class="text-end mt-4">
                        <a href="{{ route('owner.discountCategories.index') }}" class="btn btn-outline-secondary me-2">
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
@endsection
