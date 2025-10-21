@extends('auth.app')

@section('title', 'Admin Registration')

@section('content')
    <div class="wrap-login100 p-0">
        <div class="card-body">
            <form class="login100-form validate-form" action="{{ route('register') }}" method="POST">
                @csrf
                <span class="login100-form-title">
                    Admin Registration
                </span>
                <div class="wrap-input100 validate-input" data-bs-validate="Name is required">
                    <input class="input100" type="text" name="name" placeholder="Full Name" value="{{ old('name') }}">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="zmdi zmdi-account" aria-hidden="true"></i>
                    </span>
                    @error('name')
                        <span class="textt-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="wrap-input100 validate-input" data-bs-validate="Valid email is required: ex@abc.xyz">
                    <input class="input100" type="text" name="email" placeholder="Email" value="{{ old('email') }}">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="zmdi zmdi-email" aria-hidden="true"></i>
                    </span>
                    @error('email')
                        <span class="textt-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="wrap-input100 validate-input" data-bs-validate="Password is required">
                    <input class="input100" type="password" name="password" placeholder="Password">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="zmdi zmdi-lock" aria-hidden="true"></i>
                    </span>
                    @error('password')
                        <span class="textt-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="wrap-input100 validate-input" data-bs-validate="Password confirmation is required">
                    <input class="input100" type="password" name="password_confirmation" placeholder="Confirm Password">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="zmdi zmdi-lock" aria-hidden="true"></i>
                    </span>
                    @error('password_confirmation')
                        <span class="textt-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="text-end pt-1">
                    <a href="{{ route('login') }}" class="text-primary ms-1">Already have an account? Login</a>
                </div>
                <div class="container-login100-form-btn">
                    <button type="submit" class="login100-form-btn btn-primary">Register</button>
                </div>
            </form>
        </div>
    </div>
@endsection
