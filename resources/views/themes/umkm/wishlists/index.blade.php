@extends('themes.umkm.layouts.app')

@section('breadcrumb-title')
    Wishlists
@endsection

@section('breadcrumb-links')
    <a href="{{ url('/') }}">Home</a>
    <span>Wishlists</span>
@endsection

@section('content')
    <!-- Wishlist Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            @if ($wishlists->count() > 0)
                <div class="row">
                    @include('themes.umkm.partial.flash')
                    <div class="col-lg-12">
                        <div class="shoping__cart__table">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="shoping__product">Products</th>
                                        <th style="text-align: right; white-space: nowrap;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($wishlists as $wishlist)
                                        <tr>
                                            <td class="shoping__cart__item">
                                                <img src="{{ $wishlist->products->image1_url }}" height="100px"
                                                    alt="">
                                                <h5>{{ $wishlist->products->product_name }}</h5>
                                            </td>

                                            <td class="shoping__cart__item__close">
                                                <!-- Button to remove from wishlist -->
                                                {{ html()->form('delete', route('wishlists.destroy', $wishlist->id))->class('d-inline-block')->open() }}
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                {{ html()->form()->close() }}

                                                <!-- Button to add to cart -->
                                                {{ html()->form('post', route('carts.store'))->class('d-inline')->open() }}
                                                <input type="hidden" name="product_id"
                                                    value="{{ $wishlist->products->id }}" />
                                                <input type="hidden" name="quantity" value="1" />
                                                <button type="submit" class="btn btn-primary btn-sm gap-2">
                                                    <i class="fa fa-shopping-cart"></i>
                                                </button>
                                                {{ html()->form()->close() }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h3 class="mb-3">Your wishlist is empty.</h3>
                        <a href="{{ url('/shop') }}" class="primary-btn">Check Some Products</a>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!-- Wishlist Section End -->
@endsection
