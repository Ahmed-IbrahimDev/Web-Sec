@extends('app')

@section('title', 'Login')

@section('styles')
<style>
    .login-container {
        margin-top: 5%;
    }
    .login-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
    .login-card-header {
        background-color: #4e73df;
        color: white;
        text-align: center;
        font-weight: bold;
        border-radius: 10px 10px 0 0;
        padding: 20px;
    }
    .login-form {
        padding: 30px;
    }
    .login-icon {
        text-align: center;
        margin-bottom: 20px;
    }
    .login-icon i {
        font-size: 50px;
        color: #4e73df;
    }
    .btn-login {
        background-color: #4e73df;
        border-color: #4e73df;
        width: 100%;
        padding: 10px;
        font-weight: bold;
        margin-top: 20px;
    }
    .btn-login:hover {
        background-color: #2e59d9;
        border-color: #2e59d9;
    }
    .login-footer {
        text-align: center;
        margin-top: 20px;
    }
    .divider {
        position: relative;
        text-align: center;
        margin: 20px 0;
    }
    .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #ddd;
    }
    .divider span {
        background: white;
        padding: 0 15px;
        color: #666;
        font-size: 14px;
    }

    .btn-google {
        width: 100%;
        padding: 10px;
        font-weight: bold;
        border-color: #dc3545;
        color: #dc3545;
        margin-bottom: 10px;
    }
    .btn-google:hover {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
    }
</style>
@endsection

@section('content')
<div class="container login-container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card login-card">
                <div class="card-header login-card-header">
                    <h4 class="m-0">{{ __('Login to Your Account') }}</h4>
                </div>

                <div class="card-body">
                    <div class="login-icon">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('login.submit') }}" class="login-form">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter your email">
                            </div>
                            @error('email')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter your password">
                            </div>
                            @error('password')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-login">
                                <i class="fas fa-sign-in-alt me-2"></i> {{ __('Login') }}
                            </button>
                        </div>
                    </form>
                    
                    <!-- OAuth Sign-In Buttons -->
                    <div class="text-center mt-3">
                        <div class="divider">
                            <span>or</span>
                        </div>
                        <a href="{{ route('auth.google') }}" class="btn btn-outline-danger btn-google">
                            <i class="fab fa-google me-2"></i> Sign in with Google
                        </a>
                    </div>
                    
                    <div class="login-footer">
                        <p class="mb-0">Don't have an account? <a href="{{ route('register') }}" class="text-primary">Register here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection