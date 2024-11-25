@extends('themes.umkm.layouts.app')

@section('breadcrumb-title')
    Product Review
@endsection

@section('breadcrumb-links')
    <a href="{{ url('/') }}">Home</a>
    <span>Product Review</span>
@endsection

@section('content')
    <section class="review-section spad">
        <div class="container">
            <h3 class="mb-4">Review Your Purchased Products</h3>

            @auth('web')
                <!-- Formulir review -->
                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        @foreach ($order->order_details as $orderDetail)
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $orderDetail->products->product_name }}</h5>
                                        <img src="{{ asset($orderDetail->products->image1_url) }}"
                                            alt="{{ $orderDetail->products->product_name }}" class="img-fluid mb-3">

                                        <input type="hidden" name="reviews[{{ $loop->index }}][product_id]"
                                            value="{{ $orderDetail->products->id }}">

                                        <div class="form-group mb-5">
                                            <select name="reviews[{{ $loop->index }}][rating]" id="rating-{{ $loop->index }}"
                                                class="form-control" required>
                                                <option value="select">-- Select a product rating --</option>
                                                <option value="5">5 - Excellent</option>
                                                <option value="4">4 - Good</option>
                                                <option value="3">3 - Average</option>
                                                <option value="2">2 - Poor</option>
                                                <option value="1">1 - Terrible</option>
                                            </select>
                                        </div>

                                        <div class="form-group mt-5">
                                            <textarea placeholder="Comment about the product here" name="reviews[{{ $loop->index }}][comment]"
                                                id="comment-{{ $loop->index }}" class="form-control" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-success">Submit Reviews</button>
                </form>
            @else
                <p><a href="{{ route('login') }}">Log in</a> to submit a review.</p>
            @endauth

        </div>
    </section>
@endsection
