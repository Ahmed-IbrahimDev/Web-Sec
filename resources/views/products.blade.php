@extends('app')

@section('title', 'Products')

@section('styles')
<style>
    .product-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 20px rgba(78, 115, 223, 0.1);
        transition: all 0.3s ease;
    }
    .product-header:hover {
        box-shadow: 0 8px 25px rgba(78, 115, 223, 0.2);
        transform: translateY(-2px);
    }
    .product-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .product-card:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        transform: translateY(-5px);
    }
    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    .product-table {
        border-radius: 10px;
        overflow: hidden;
    }
    .product-table th {
        background-color: #f8f9fc;
        color: #4e73df;
        font-weight: bold;
    }
    .product-table td {
        vertical-align: middle;
    }
    .product-description {
        max-width: 300px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .btn-add-product {
        background-color: #1cc88a;
        border-color: #1cc88a;
        color: white;
        font-weight: bold;
        padding: 10px 20px;
        border-radius: 5px;
    }
    .btn-add-product:hover {
        background-color: #17a673;
        border-color: #17a673;
        color: white;
    }
    .product-count {
        background-color: #f6c23e;
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: bold;
    }
    .action-buttons .btn {
        margin-right: 5px;
        border-radius: 5px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        z-index: 1;
    }
    .action-buttons .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    .action-buttons .btn::after {
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
    .action-buttons .btn:hover::after {
        height: 100%;
    }
    .btn-view {
        background-color: #4e73df;
        border-color: #4e73df;
        color: white;
        transition: all 0.3s ease;
    }
    .btn-view:hover {
        background-color: #2e59d9;
        border-color: #2e59d9;
        color: white;
        transform: scale(1.05);
    }
    .product-table tr:hover {
        background-color: #f8f9fc;
    }
    .empty-state {
        padding: 30px;
        text-align: center;
    }
    .product-badge {
        font-size: 0.85rem;
        padding: 0.35em 0.65em;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="product-header">
        <div>
            <h1 class="h3 mb-0"><i class="fas fa-boxes me-2"></i>Products Management</h1>
            <p class="mb-0"><i class="fas fa-clipboard-list me-1"></i> Manage your product inventory</p>
        </div>
        <div class="product-count">
            <i class="fas fa-tag me-1"></i> {{ count($products) }} Products
        </div>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm">
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <i class="fas fa-check-circle fa-2x"></i>
                </div>
                <div>
                    <strong>Success!</strong>
                    <p class="mb-0">{{ session('success') }}</p>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="card product-card">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Product List</h6>
            @if (Auth::check() && (Auth::user()->hasRole('employee') || Auth::user()->hasRole('owner') || Auth::user()->hasRole('super_admin') || Auth::user()->hasRole('admin')))
            <a href="{{ route('products.create') }}" class="btn btn-add-product">
                <i class="fas fa-plus-circle me-2"></i> Add New Product
            </a>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover product-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag me-1"></i> ID</th>
                            <th><i class="fas fa-box me-1"></i> Product</th>
                            <th><i class="fas fa-align-left me-1"></i> Description</th>
                            <th><i class="fas fa-dollar-sign me-1"></i> Price</th>
                            <th class="text-center"><i class="fas fa-cogs me-1"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td><span class="badge bg-secondary product-badge">#{{ $product->id }}</span></td>
                                <td>
                                    <strong><i class="fas fa-tag text-primary me-1"></i> {{ $product->name }}</strong>
                                </td>
                                <td>
                                    <div class="product-description" title="{{ $product->description }}">
                                        <i class="fas fa-info-circle text-muted me-1"></i> {{ $product->description }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-success product-badge"><i class="fas fa-dollar-sign me-1"></i> {{ number_format($product->price, 2) }}</span>
                                </td>
                                <td class="text-center action-buttons">
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-view" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if (Auth::check() && (Auth::user()->hasRole('employee') || Auth::user()->hasRole('owner') || Auth::user()->hasRole('super_admin') || Auth::user()->hasRole('admin')))
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-info" title="Edit Product">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete Product" onclick="return confirm('Are you sure you want to delete this product?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="empty-state text-muted">
                                        <i class="fas fa-box-open fa-4x mb-3 text-secondary"></i>
                                        <h5>No Products Found</h5>
                                        <p>Your product inventory is currently empty</p>
                                        @if (Auth::check() && (Auth::user()->hasRole('employee') || Auth::user()->hasRole('owner') || Auth::user()->hasRole('super_admin') || Auth::user()->hasRole('admin')))
                                            <a href="{{ route('products.create') }}" class="btn btn-primary mt-2">
                                                <i class="fas fa-plus-circle me-2"></i> Add Your First Product
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection