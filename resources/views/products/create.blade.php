@extends('app')

@section('title', 'Create Product')

@section('styles')
<style>
    .product-form-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 4px 20px rgba(78, 115, 223, 0.1);
        transition: all 0.3s ease;
    }
    .product-form-header:hover {
        box-shadow: 0 8px 25px rgba(78, 115, 223, 0.2);
        transform: translateY(-2px);
    }
    .product-form-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .product-form-card:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        transform: translateY(-5px);
    }
    .product-form-card .card-header {
        background-color: #f8f9fc;
        color: #4e73df;
        font-weight: bold;
        border-bottom: 1px solid #e3e6f0;
        padding: 15px 20px;
    }
    .form-label {
        font-weight: 600;
        color: #5a5c69;
    }
    .btn-create-product {
        background-color: #1cc88a;
        border-color: #1cc88a;
        color: white;
        font-weight: bold;
        padding: 10px 20px;
        border-radius: 5px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        z-index: 1;
    }
    .btn-create-product:hover {
        background-color: #17a673;
        border-color: #17a673;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(28, 200, 138, 0.3);
    }
    .btn-create-product::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 0;
        background: rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
        z-index: -1;
    }
    .btn-create-product:hover::after {
        height: 100%;
    }
    .btn-cancel {
        background-color: #e74a3b;
        border-color: #e74a3b;
        color: white;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        z-index: 1;
    }
    .btn-cancel:hover {
        background-color: #d52a1a;
        border-color: #d52a1a;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(231, 74, 59, 0.3);
    }
    .btn-cancel::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 0;
        background: rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
        z-index: -1;
    }
    .btn-cancel:hover::after {
        height: 100%;
    }
    .input-group-text {
        background-color: #4e73df;
        color: white;
        border: none;
        transition: all 0.3s ease;
    }
    .form-control {
        transition: all 0.3s ease;
        border: 1px solid #d1d3e2;
    }
    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        transform: translateY(-2px);
    }
    .input-group:focus-within .input-group-text {
        background-color: #224abe;
        transform: translateY(-2px);
    }
    .invalid-feedback {
        font-size: 0.85rem;
        margin-top: 0.5rem;
        color: #e74a3b;
        animation: fadeIn 0.5s;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="product-form-header">
        <div>
            <h1 class="h3 mb-0"><i class="fas fa-plus-circle me-2"></i>Create New Product</h1>
            <p class="mb-0"><i class="fas fa-clipboard-list me-1"></i> Add a new product to your inventory</p>
        </div>
        <div>
            <i class="fas fa-box-open fa-2x text-white-50"></i>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card product-form-card">
                <div class="card-header">
                    <i class="fas fa-box-open me-2"></i> Product Details
                </div>
                
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('products.store') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="name" class="form-label">Product Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Enter product name" required autofocus>
                            </div>
                            @error('name')
                                <div class="invalid-feedback d-block mt-1">
                                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="form-label">Product Description</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="5" placeholder="Enter product description" required>{{ old('description') }}</textarea>
                            </div>
                            @error('description')
                                <div class="invalid-feedback d-block mt-1">
                                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="price" class="form-label">Product Price</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                <input id="price" type="number" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" placeholder="0.00" required>
                            </div>
                            @error('price')
                                <div class="invalid-feedback d-block mt-1">
                                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between mt-5">
                            <a href="{{ route('products') }}" class="btn btn-cancel">
                                <i class="fas fa-times me-2"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-create-product">
                                <i class="fas fa-plus-circle me-2"></i> Create Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection