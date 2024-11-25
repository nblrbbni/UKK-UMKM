<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="preconnect" href="https://fonts.gstatic.com">

    <title>Owner Dashboard</title>

    <link href="{{ asset('owner/css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        @include('owner.partial.sidebar')

        <div class="main">
            @include('owner.partial.navbar')

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3">@yield('title')</h1>

                    @yield('content')

                </div>
            </main>

            @include('owner.partial.footer')
        </div>
    </div>

    <script src="{{ asset('owner/js/app.js') }}"></script>
</body>

</html>
