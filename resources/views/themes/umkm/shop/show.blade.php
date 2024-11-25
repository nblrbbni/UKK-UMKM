@extends('themes.umkm.layouts.app')

@section('breadcrumb-title')
    Shop Details Page
@endsection

@section('breadcrumb-links')
    <a href="{{ url('/') }}">Home</a>
    <a href="{{ url('/shop') }}">Shop</a>
    <a href="{{ shop_category_link($category) }}">{{ $product->product_category->category_name }}</a>
    <span>{{ $product->product_name }}</span>
@endsection

@section('content')
    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <img class="product__details__pic__item--large" src="{{ asset($product->image1_url) }}"
                                alt="">
                        </div>
                        <div class="product__details__pic__slider owl-carousel">
                            @foreach (array_filter([$product->image1_url, $product->image2_url, $product->image3_url, $product->image4_url, $product->image5_url]) as $image)
                                <img data-imgbigurl="{{ asset($image) }}" src="{{ asset($image) }}" alt="">
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3>{{ $product->product_name }}</h3>
                        <div class="product__details__rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-o"></i>
                            <span>(18 reviews)</span>
                        </div>
                        <div class="product__details__price">
                            @if ($product->has_discount)
                                <span>Rp{{ $product->discounted_price_label }}</span>
                                <span class="original-price" style="text-decoration: line-through; color: grey;">
                                    Rp{{ $product->price_label }}
                                </span>
                            @else
                                Rp{{ $product->price_label }}
                            @endif
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            {{ html()->form('post', route('carts.store'))->class('d-flex align-items-center gap-3')->open() }}
                            <input type="hidden" name="product_id" value="{{ $product->id }}" />
                            <div class="product__details__quantity">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="number" name="quantity" value="1" min="1">
                                    </div>
                                </div>
                            </div>
                            <button class="primary-btn" style="border: none" type="submit">ADD TO CARD</button>
                            {{ html()->form()->close() }}

                            {{ html()->form('post', route('wishlists.store'))->class('d-inline-block')->open() }}
                            <input type="hidden" name="product_id" value="{{ $product->id }}" />
                            <button class="heart-icon" style="border: none" type="submit">
                                <span class="icon_heart_alt" style="font-size: 20px;"></span>
                            </button>
                            {{ html()->form()->close() }}
                        </div>
                        <ul>
                            <li><b>Weight</b> <span>{{ $product->weight }}</span></li>
                            <li><b>Availability</b> <span>{{ $product->stock_status }}</span>
                            </li>
                            <li><b>Type</b> <span>{{ $product->product_category->category_name }}</span></li>
                            <li><b>Share on</b>
                                <div class="share">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                    aria-selected="false">Information</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"
                                    aria-selected="false">Reviews</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Product Infomation</h6>
                                    <p>{!! nl2br(e($product->description)) !!}</p>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-2" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Customer Reviews</h6>

                                    <!-- Display Reviews -->
                                    @forelse ($product->product_reviews as $review)
                                        <div class="review-item mb-4">
                                            <h5 class="mb-1">{{ $review->customers->name }}</h5>
                                            <p class="mb-1">
                                                <i class="fa fa-star"></i> {{ $review->rating }} / 5
                                            </p>
                                            <p>{{ $review->comment }}</p>
                                            <hr>
                                        </div>
                                    @empty
                                        <p>No reviews yet. Be the first to review this product!</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->

    <!-- Related Product Section Begin -->
    <section class="related-product">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related__product__title">
                        <h2>Related Product</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse ($relatedProducts as $relatedProduct)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="{{ $relatedProduct->image1_url }}">
                                <ul class="product__item__pic__hover">
                                    <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                    <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                    <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a href="{{ shop_product_link($relatedProduct) }}"
                                        class="hover-underline">{{ $relatedProduct->product_name }}</a></h6>
                                <h5>Rp{{ $relatedProduct->price_label }}</h5>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col">
                        <p class="text-center">No Related Product</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- Related Product Section End -->
@endsection
