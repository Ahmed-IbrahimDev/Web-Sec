@extends('app')

@section('title', 'Edit Product')

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
        display: flex;
        justify-content: space-between;
        align-items: center;
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
        transition: all 0.3s ease;
    }
    .product-form-card:hover .card-header {
        background-color: #eaecf4;
    }
    .form-label {
        font-weight: 600;
        color: #5a5c69;
    }
    .btn-update-product {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border-color: #4e73df;
        color: white;
        font-weight: bold;
        padding: 10px 20px;
        border-radius: 5px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(78, 115, 223, 0.2);
        position: relative;
        overflow: hidden;
    }
    .btn-update-product:hover {
        background: linear-gradient(135deg, #3a5fc8 0%, #1a3ba0 100%);
        border-color: #2e59d9;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(78, 115, 223, 0.3);
    }
    .btn-update-product:active {
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(78, 115, 223, 0.3);
    }
    .btn-update-product::after {
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
    .btn-update-product:hover::after {
        transform: translateX(0);
    }
    .btn-cancel {
        background: linear-gradient(135deg, #e74a3b 0%, #c52e1f 100%);
        border-color: #e74a3b;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(231, 74, 59, 0.2);
        position: relative;
        overflow: hidden;
    }
    .btn-cancel:hover {
        background: linear-gradient(135deg, #d93a2b 0%, #b52a1c 100%);
        border-color: #d52a1a;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(231, 74, 59, 0.3);
    }
    .btn-cancel:active {
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(231, 74, 59, 0.3);
    }
    .btn-cancel::after {
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
    .btn-cancel:hover::after {
        transform: translateX(0);
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
    .product-id-badge {
        background: linear-gradient(135deg, #f6c23e 0%, #e0a800 100%);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: bold;
        display: inline-block;
        margin-bottom: 10px;
        box-shadow: 0 2px 10px rgba(246, 194, 62, 0.3);
        transition: all 0.3s ease;
        animation: pulse 2s infinite;
    }
    .product-id-badge:hover {
        box-shadow: 0 4px 15px rgba(246, 194, 62, 0.5);
        transform: translateY(-2px);
    }
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(246, 194, 62, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(246, 194, 62, 0); }
        100% { box-shadow: 0 0 0 0 rgba(246, 194, 62, 0); }
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="product-form-header">
        <div>
            <h1 class="h3 mb-0"><i class="fas fa-edit me-2"></i>Edit Product</h1>
            <p class="mb-0"><i class="fas fa-clipboard-list me-1"></i> Update product information</p>
        </div>
        <div>
            <i class="fas fa-box-open fa-2x text-white-50"></i>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card product-form-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-edit me-2"></i> Edit Product Details
                    </div>
                    <div class="product-id-badge">
                        ID: #{{ $product->id }}
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('products.update', $product->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="name" class="form-label">Product Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $product->name) }}" placeholder="Enter product name" required autofocus>
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
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="5" placeholder="Enter product description" required>{{ old('description', $product->description) }}</textarea>
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
                                <input id="price" type="number" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', $product->price) }}" placeholder="0.00" required>
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
                            <button type="submit" class="btn btn-update-product">
                                <i class="fas fa-save me-2"></i> Update Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection