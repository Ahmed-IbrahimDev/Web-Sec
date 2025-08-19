@extends('app')

@section('title', 'Register')

@section('styles')
<style>
    .register-container {
        margin-top: 5%;
    }
    .register-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
    .register-card-header {
        background-color: #1cc88a;
        color: white;
        text-align: center;
        font-weight: bold;
        border-radius: 10px 10px 0 0;
        padding: 20px;
    }
    .register-form {
        padding: 30px;
    }
    .register-icon {
        text-align: center;
        margin-bottom: 20px;
    }
    .register-icon i {
        font-size: 50px;
        color: #1cc88a;
    }
    .btn-register {
        background-color: #1cc88a;
        border-color: #1cc88a;
        width: 100%;
        padding: 10px;
        font-weight: bold;
        margin-top: 20px;
    }
    .btn-register:hover {
        background-color: #17a673;
        border-color: #17a673;
    }
    .register-footer {
        text-align: center;
        margin-top: 20px;
    }
</style>
@endsection

@section('content')
<div class="container register-container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card register-card">
                <div class="card-header register-card-header">
                    <h4 class="m-0">{{ __('Create Your Account') }}</h4>
                </div>

                <div class="card-body">
                    <div class="register-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('register.submit') }}" class="register-form">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Full Name') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Enter your full name">
                            </div>
                            @error('name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter your email address">
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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Create a password">
                            </div>
                            @error('password')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                            <label class="form-check-label" for="terms">
                                {{ __('I agree to the Terms and Conditions') }}
                            </label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-register">
                                <i class="fas fa-user-plus me-2"></i> {{ __('Register') }}
                            </button>
                        </div>
                    </form>
                    
                    <div class="register-footer">
                        <p class="mb-0">Already have an account? <a href="{{ route('login') }}" class="text-success">Login here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection