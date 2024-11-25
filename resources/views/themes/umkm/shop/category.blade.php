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
                                    @foreach ($product_categories as $cat)
                                        <li><a href="{{ shop_category_link($cat) }}"
                                                class="hover-underline">{{ $cat->category_name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-7">
                    <div class="section-title product__discount__title">
                        <h2>{{ $category->category_name }}</h2>
                    </div>
                    {{-- @include('themes.umkm.partial.filter') --}}

                    <div class="row">
                        @forelse ($products as $product)
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="{{ $product->image1_url }}">
                                        <ul class="product__item__pic__hover">
                                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                            <li><a href="shop_product_link($product)"><i
                                                        class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="product__item__text">
                                        <h6><a href="{{ shop_product_link($product) }}" class="hover-underline">
                                                {{ $product->product_name }}</a></h6>
                                        <h5>Rp{{ $product->price_label }}</h5>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col">
                                <p>Product Empty</p>
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
