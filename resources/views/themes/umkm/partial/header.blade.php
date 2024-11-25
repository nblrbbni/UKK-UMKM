<!-- Header Section Begin -->
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__left">
                        <ul>
                            <li>Free shipping for every purchase above Rp99.000</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__right">
                        <div class="header__top__right__social">
                            <a href="#"><i class="fa fa-instagram" style="transition: all 0.3s;"
                                    onmouseover="this.style.color='#7fad39'"
                                    onmouseout="this.style.color='#1c1c1c'"></i></a>
                            <a href="#"><i class="fa fa-facebook" style="transition: all 0.3s;"
                                    onmouseover="this.style.color='#7fad39'"
                                    onmouseout="this.style.color='#1c1c1c'"></i></a>
                            <a href="#"><i class="fa fa-twitter" style="transition: all 0.3s;"
                                    onmouseover="this.style.color='#7fad39'"
                                    onmouseout="this.style.color='#1c1c1c'"></i></a>
                        </div>

                        <div class="header__top__right__auth">
                            @guest
                                <div class="d-flex align-items-center">
                                    @if (Route::has('login'))
                                        <a href="{{ route('login') }}" style="margin-left: 10px; transition: all 0.3s;"
                                            onmouseover="this.style.color='#7fad39'"
                                            onmouseout="this.style.color='#1c1c1c'">
                                            <i class="fa fa-user"></i> Login
                                        </a>
                                    @endif

                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" style="margin-left: 10px; transition: all 0.3s;"
                                            onmouseover="this.style.color='#7fad39'"
                                            onmouseout="this.style.color='#1c1c1c'">
                                            <i class="fa fa-user-plus"></i> Register
                                        </a>
                                    @endif
                                </div>
                            @else
                                <div class="dropdown">
                                    <a id="navbarDropdown" class="dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre
                                        style="transition: all 0.3s;" onmouseover="this.style.color='#7fad39'"
                                        onmouseout="this.style.color='#1c1c1c'">
                                        <i class="fa fa-user"></i> {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('orders.index') }}">
                                            My Orders
                                        </a>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            @endguest
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="header__logo">
                    <a href="{{ url('/') }}"><img src="{{ asset('img/logo.png') }}" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6">
                <nav class="header__menu">
                    <ul>
                        <li class="{{ request()->is('/') ? 'active' : '' }}"><a href="{{ url('/') }}">Home</a>
                        </li>
                        <li
                            class="{{ Route::is('shop.*') || Route::is('category.*') || Route::is('product.*') ? 'active' : '' }}">
                            <a href="{{ url('/shop') }}">Shop</a>
                        </li>
                        <li class="{{ request()->is('blog') ? 'active' : '' }}"><a href="{{ url('/blog') }}">Blog</a>
                        </li>
                        <li class="{{ request()->is('contact') ? 'active' : '' }}"><a
                                href="{{ url('/contact') }}">Contact</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="header__cart">
                    <ul>
                        <li><a href="{{ route('wishlists.index') }}"> <i class="fa fa-heart"
                                    style="transition: all 0.3s;" onmouseover="this.style.color='#7fad39'"
                                    onmouseout="this.style.color='#1c1c1c'">
                                    {{-- <span>3</span> --}}
                                </i>
                            </a></li>
                        <li><a href="{{ route('carts.index') }}"> <i class="fa fa-shopping-cart"
                                    style="transition: all 0.3s;" onmouseover="this.style.color='#7fad39'"
                                    onmouseout="this.style.color='#1c1c1c'">
                                    {{-- <span>3</span> --}}
                                </i>
                            </a></li>
                    </ul>
                    <div class="header__cart__price">
                        item: <span>Rp{{ number_format($cartTotal ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="humberger__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
<!-- Header Section End -->
