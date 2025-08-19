@extends('app')

@section('title', 'Catalog')

@section('styles')
<style>
    .catalog-header {
        background-color: #f8f9fc;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }
    .product-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 20px rgba(0, 0, 0, 0.1);
    }
    .product-card .card-body {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .product-card .card-title {
        color: #4e73df;
        font-weight: 600;
    }
    .product-card .card-text {
        flex-grow: 1;
    }
    .product-price {
        font-size: 1.25rem;
        color: #1cc88a;
        font-weight: 700;
        margin-bottom: 15px;
    }
    .btn-view-details {
        background-color: #4e73df;
        border-color: #4e73df;
        color: white;
        font-weight: 600;
        border-radius: 5px;
        padding: 8px 16px;
        transition: all 0.3s ease;
    }
    .btn-view-details:hover {
        background-color: #2e59d9;
        border-color: #2e59d9;
        transform: translateX(5px);
    }
    .empty-catalog {
        text-align: center;
        padding: 50px 0;
        background-color: #f8f9fc;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }
    .pagination {
        justify-content: center;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="catalog-header d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 mb-0"><i class="fas fa-th-list me-2"></i>Product Catalog</h1>
            <p class="text-muted mb-0">Browse our available products</p>
        </div>
        <div class="d-flex align-items-center">
            <span class="badge bg-primary rounded-pill me-2">{{ $products->total() }} Products</span>
        </div>
    </div>
    
    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card product-card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-tag me-2"></i>{{ $product->name }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($product->description, 100) }}</p>
                        <div class="product-price">
                            <i class="fas fa-dollar-sign me-1"></i>${{ number_format($product->price, 2) }}
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('catalog.show', $product->id) }}" class="btn btn-view-details">
                                <i class="fas fa-eye me-1"></i> View Details
                            </a>
                            @auth
                                @if(Auth::user()->hasRole('custmer'))
                                    <form action="{{ route('purchase.buy', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-cart-plus me-1"></i> Buy
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-catalog">
                    <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                    <h4>No Products Available</h4>
                    <p class="text-muted">There are currently no products available in our catalog.</p>
                    <p>Please check back later for new additions.</p>
                </div>
            </div>
        @endforelse
    </div>
    
    <div class="mt-4 pagination-container">
        {{ $products->links() }}
    </div>
</div>
@endsection