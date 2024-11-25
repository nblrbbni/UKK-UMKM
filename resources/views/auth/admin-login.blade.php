@extends('layouts.app-auth')

@section('content')
    <div class="bg order-1 order-md-2" style="background-image: url('{{ asset('auth/images/sayur.png') }}');"></div>
    <div class="contents order-2 order-md-1">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-7">
                    <div class="mb-4">
                        <h3>Login as ADMIN</h3>
                        <p class="mb-4">Please enter your credentials to access the admin dashboard.</p>
                    </div>
                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-flex mb-5 align-items-center">
                            <label class="control control--checkbox mb-0">
                                <span class="caption">Remember Me</span>
                                <input type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <div class="control__indicator"></div>
                            </label>
                        </div>

                        <input type="submit" value="Log In" class="btn btn-block btn-success">

                        <div class="mt-3 text-center">
                            <p>Not an admin? <a href="{{ route('login') }}">Login as Customer</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
