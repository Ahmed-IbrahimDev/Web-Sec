@extends('app')

@section('title', 'Welcome')

@section('styles')
<style>
    .welcome-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        padding: 60px 0;
        border-radius: 15px;
        margin-bottom: 40px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    .welcome-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 15px;
    }
    .welcome-subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
    }
    .feature-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
        overflow: hidden;
    }
    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    .feature-card .card-body {
        padding: 25px;
    }
    .feature-icon {
        font-size: 2.5rem;
        margin-bottom: 20px;
        color: #4e73df;
    }
    .feature-card .card-title {
        font-weight: 700;
        font-size: 1.4rem;
        margin-bottom: 15px;
        color: #4e73df;
    }
    .feature-card .card-text {
        color: #6c757d;
        margin-bottom: 25px;
    }
    .feature-btn {
        border-radius: 50px;
        padding: 8px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .feature-btn:hover {
        transform: translateX(5px);
    }
    .btn-products {
        background-color: #4e73df;
        border-color: #4e73df;
    }
    .btn-dashboard {
        background-color: #1cc88a;
        border-color: #1cc88a;
    }
    .btn-utilities {
        background-color: #f6c23e;
        border-color: #f6c23e;
    }
    .utility-btn {
        border-radius: 50px;
        font-size: 0.85rem;
        padding: 5px 15px;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="welcome-header text-center">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <i class="fas fa-shield-alt fa-4x mb-3"></i>
                <h1 class="welcome-title">Welcome to WebSec Application</h1>
                <p class="welcome-subtitle">A secure web application built with Laravel and Bootstrap</p>
                <div class="mt-4">
                    <a href="{{ route('login') }}" class="btn btn-light btn-lg me-2 feature-btn">
                        <i class="fas fa-sign-in-alt me-2"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg feature-btn">
                        <i class="fas fa-user-plus me-2"></i> Register
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card feature-card">
                <div class="card-body text-center">
                    <div class="feature-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <h5 class="card-title">Products</h5>
                    <p class="card-text">Browse our product catalog and manage your inventory with our easy-to-use interface.</p>
                    <a href="{{ route('products') }}" class="btn btn-products text-white feature-btn">
                        <i class="fas fa-arrow-right me-2"></i> View Products
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card feature-card">
                <div class="card-body text-center">
                    <div class="feature-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <h5 class="card-title">Dashboard</h5>
                    <p class="card-text">Access your dashboard to view statistics, analytics, and manage your account settings.</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-dashboard text-white feature-btn">
                        <i class="fas fa-arrow-right me-2"></i> Go to Dashboard
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card feature-card">
                <div class="card-body text-center">
                    <div class="feature-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h5 class="card-title">Utilities</h5>
                    <p class="card-text">Access useful utilities like Even Numbers and Multiplication Table generators for your calculations.</p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('even-numbers') }}" class="btn btn-utilities text-dark utility-btn">
                            <i class="fas fa-calculator me-1"></i> Even Numbers
                        </a>
                        <a href="{{ route('multiplication') }}" class="btn btn-utilities text-dark utility-btn">
                            <i class="fas fa-table me-1"></i> Multiplication
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
