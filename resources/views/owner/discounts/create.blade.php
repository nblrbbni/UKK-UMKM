@extends('layouts.owner.app')

@section('title')
Discounts
@endsection

@section('title-2')
Create New Discount
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <h5 class="card-header">Create Discount</h5>
            <div class="card-body">
                <form action="{{ route('owner.discounts.store') }}" method="POST">
                    @csrf

                    <!-- Discount Category -->
                    <div class="mb-3">
                        <label for="category_discount_id" class="form-label">Discount Category</label>
                        <select class="form-control @error('category_discount_id') is-invalid @enderror" id="category_discount_id" name="category_discount_id">
                            <option value="" disabled selected>Choose a category</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_discount_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_discount_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Product -->
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Product</label>
                        <select class="form-control @error('product_id') is-invalid @enderror" id="product_id" name="product_id">
                            <option value="" disabled selected>Choose a product</option>
                            @foreach ($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->product_name }}
                            </option>
                            @endforeach
                        </select>
                        @error('product_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Start Date -->
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}" />
                        @error('start_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- End Date -->
                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}" />
                        @error('end_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Percentage -->
                    <div class="mb-3">
                        <label for="percentage" class="form-label">Discount Percentage (%)</label>
                        <input type="number" class="form-control @error('percentage') is-invalid @enderror" id="percentage" name="percentage" value="{{ old('percentage') }}" min="1" max="100" />
                        @error('percentage')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <!-- Action Buttons -->
                    <div class="text-end mt-4">
                        <a href="{{ route('owner.discounts.index') }}" class="btn btn-outline-secondary me-2">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Cancel</span>
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Create Discount</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
