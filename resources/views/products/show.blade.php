@extends('app')

@section('title', 'Product Details')

@section('styles')
<style>
    .product-card {
        transition: all 0.3s ease;
        border-radius: 15px;
        overflow: hidden;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
    }
    .card-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
        transition: all 0.3s ease;
    }
    .product-card:hover .card-header {
        background: linear-gradient(135deg, #3a5fc8 0%, #1a3ba0 100%) !important;
    }
    .product-row {
        transition: all 0.3s ease;
        border-radius: 8px;
        padding: 10px 0;
    }
    .product-row:hover {
        background-color: #f8f9fc;
        transform: translateX(5px);
    }
    .product-label {
        color: #5a5c69;
        font-weight: 600;
    }
    .product-value {
        position: relative;
    }
    .product-value::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 3px;
        background: linear-gradient(to bottom, #4e73df, #224abe);
        border-radius: 3px;
    }
    .price-value {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1cc88a !important;
        text-shadow: 0 0 1px rgba(28, 200, 138, 0.2);
    }
    .btn-action {
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        position: relative;
        overflow: hidden;
    }
    .btn-action::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.2);
        transform: translateX(-100%);
        transition: transform 0.6s;
    }
    .btn-action:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }
    .btn-action:hover::after {
        transform: translateX(0);
    }
    .btn-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border: none;
    }
    .btn-secondary {
        background: linear-gradient(135deg, #858796 0%, #6e707e 100%);
        border: none;
    }
    .btn-danger {
        background: linear-gradient(135deg, #e74a3b 0%, #c52e1f 100%);
        border: none;
    }
    .alert-success {
        border-left: 5px solid #1cc88a;
        background-color: rgba(28, 200, 138, 0.1);
        color: #1cc88a;
        animation: slideIn 0.5s ease-out;
    }
    @keyframes slideIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 product-card">
                <div class="card-header text-white">
                    <h4 class="mb-0"><i class="fas fa-box-open me-2"></i>Product Details</h4>
                </div>

                <div class="card-body p-4">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle me-2 fa-2x"></i>
                            <div>
                                <strong>Success!</strong>
                                <p class="mb-0">{{ session('success') }}</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    
                    <div class="product-row row mb-3">
                        <div class="col-md-4 product-label"><i class="fas fa-hashtag me-2"></i>ID:</div>
                        <div class="col-md-8 product-value ps-4">{{ $product->id }}</div>
                    </div>

                    <div class="product-row row mb-3">
                        <div class="col-md-4 product-label"><i class="fas fa-tag me-2"></i>Name:</div>
                        <div class="col-md-8 product-value ps-4">{{ $product->name }}</div>
                    </div>

                    <div class="product-row row mb-3">
                        <div class="col-md-4 product-label"><i class="fas fa-align-left me-2"></i>Description:</div>
                        <div class="col-md-8 product-value ps-4">{{ $product->description }}</div>
                    </div>

                    <div class="product-row row mb-3">
                        <div class="col-md-4 product-label"><i class="fas fa-dollar-sign me-2"></i>Price:</div>
                        <div class="col-md-8 product-value ps-4 price-value">${{ number_format($product->price, 2) }}</div>
                    </div>

                    <div class="product-row row mb-3">
                        <div class="col-md-4 product-label"><i class="fas fa-calendar-plus me-2"></i>Created At:</div>
                        <div class="col-md-8 product-value ps-4">{{ $product->created_at->format('F d, Y H:i:s') }}</div>
                    </div>

                    <div class="product-row row mb-3">
                        <div class="col-md-4 product-label"><i class="fas fa-calendar-check me-2"></i>Updated At:</div>
                        <div class="col-md-8 product-value ps-4">{{ $product->updated_at->format('F d, Y H:i:s') }}</div>
                    </div>
                    
                    <hr class="my-4">

                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-between align-items-center">
                            <div>
                                @auth
                                    @if(Auth::user()->hasRole('custmer'))
                                        <a href="{{ route('catalog') }}" class="btn btn-secondary btn-action" title="Back to catalog">
                                            <i class="fas fa-list me-1"></i> Back to Catalog
                                        </a>
                                    @else
                                        <a href="{{ route('products') }}" class="btn btn-secondary btn-action" title="Return to products list">
                                            <i class="fas fa-list me-1"></i> Back to List
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('catalog') }}" class="btn btn-secondary btn-action" title="Back to catalog">
                                        <i class="fas fa-list me-1"></i> Back to Catalog
                                    </a>
                                @endauth
                            </div>
                            <div class="d-flex gap-2">
                                @auth
                                    @if(Auth::user()->hasRole('custmer'))
                                        <form action="{{ route('purchase.buy', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-action" title="Buy this product">
                                                <i class="fas fa-cart-plus me-1"></i> Buy
                                            </button>
                                        </form>
                                    @endif
                                    @if (Auth::check() && (Auth::user()->hasRole('employee') || Auth::user()->hasRole('owner') || Auth::user()->hasRole('super_admin') || Auth::user()->hasRole('admin')))
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-action" title="Edit this product">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-action" title="Delete this product" onclick="return confirm('Are you sure you want to delete this product?')">
                                                <i class="fas fa-trash-alt me-1"></i> Delete
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection