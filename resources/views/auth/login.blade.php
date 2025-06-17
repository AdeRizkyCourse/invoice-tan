@extends('layouts.login')

@section('content')
<style>
    .login-container {
        max-width: 900px;
        margin-top: 50px;
        background: #fff;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        border-radius: 10px;
        overflow: hidden;
    }

    .login-image {
        background: url('https://img.freepik.com/free-vector/invoice-concept-illustration_114360-2143.jpg') no-repeat center center;
        background-size: cover;
    }

    .login-form {
        padding: 40px;
    }
</style>

<div class="container login-container d-flex">
    <!-- Image Side -->
    <div class="col-md-6 login-image d-none d-md-block"></div>

    <!-- Form Side -->
    <div class="col-md-6 login-form">
        <h4 class="mb-4 text-center">Login</h4>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email"
                       name="email"
                       id="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}"
                       required
                       autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password"
                       name="password"
                       id="password"
                       class="form-control @error('password') is-invalid @enderror"
                       required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="mb-3 form-check">
                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                <label class="form-check-label" for="remember">Remember Me</label>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <p class="mt-4 text-center">
            Belum punya akun? <a class="btn btn-outline-danger btn-sm" href="{{ route('register') }}">Register</a>
        </p>
    </div>
</div>
@endsection
