@extends('themes.umkm.layouts.app')

@section('breadcrumb-title')
    Shop Page
@endsection

@section('breadcrumb-links')
    <a href="{{ url('/') }}">Home</a>
    <span>Shop</span>
@endsection

@section('content')
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-5">
                    <div class="sidebar">
                        <div class="sidebar__item">
                            @if ($product_categories->count() > 0)
                                <h4>Categories</h4>
                                <ul>
                                    @foreach ($product_categories as $category)
                                        <li><a href="{{ shop_category_link($category) }}"
                                                class="hover-underline">{{ $category->category_name }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-7">
                    <div class="row">
                        @forelse ($products as $product)
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="{{ $product->image1_url }}">
                                        <ul class="product__item__pic__hover">
                                            <!-- Wishlist Button -->
                                            <li>
                                                <form action="{{ route('wishlists.store') }}" method="POST"
                                                    class="add-to-wishlist-form">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <button type="submit" class="btn btn-light"
                                                        style="border: none; border-radius:100%;"><i
                                                            class="fa fa-heart"></i></button>
                                                </form>
                                            </li>
                                            <!-- Add to Cart Button -->
                                            <li>
                                                <form action="{{ route('carts.store') }}" method="POST"
                                                    class="add-to-cart-form">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button type="submit" class="btn btn-light"
                                                        style="border: none; border-radius:100%;"><i
                                                            class="fa fa-shopping-cart"></i></button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="product__item__text">
                                        <h6><a href="{{ shop_product_link($product) }}"
                                                class="hover-underline">{{ $product->product_name }}</a></h6>
                                        @if ($product->has_discount)
                                            <h5>Rp{{ $product->discounted_price_label }}</h5>
                                            <h5 class="original-price" style="text-decoration: line-through; color: grey;">
                                                Rp{{ $product->price_label }}
                                            </h5>
                                        @else
                                            <h5>Rp{{ $product->price_label }}</h5>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col">
                                <p class="text-center">Product Empty</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="row">
                        <div class="col">
                            {!! $products->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
