<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>OGANI</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('auth/fonts/icomoon/style.css') }}">
    <link rel="stylesheet" href="{{ asset('auth/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('auth/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('auth/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">
</head>

<body>
    <div id="app">
        <!-- Header for Auth Pages -->
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
                                <div class="header__top__right__auth">
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('owner.login') }}"
                                            style="margin-left: 10px; transition: all 0.3s;"
                                            onmouseover="this.style.color='#7fad39'"
                                            onmouseout="this.style.color='#1c1c1c'">
                                            <i class="fa fa-user"></i> Owner Login
                                        </a>
                                        <a href="{{ route('admin.login') }}"
                                            style="margin-left: 10px; transition: all 0.3s;"
                                            onmouseover="this.style.color='#7fad39'"
                                            onmouseout="this.style.color='#1c1c1c'">
                                            <i class="fa fa-user"></i> Admin Login
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- End of Header -->

        <div class="d-lg-flex half">
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('auth/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('auth/js/popper.min.js') }}"></script>
    <script src="{{ asset('auth/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('auth/js/main.js') }}"></script>
</body>


</html>
