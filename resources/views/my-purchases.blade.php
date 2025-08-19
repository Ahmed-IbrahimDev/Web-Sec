@extends('app')

@section('title', 'My Purchases')

@section('content')
<div class="container py-4">
    <h1 class="h4 mb-3"><i class="fas fa-shopping-bag me-2"></i>My Purchases</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($purchases->isEmpty())
        <div class="text-center p-5 bg-light rounded">
            <i class="fas fa-box-open fa-3x text-muted mb-2"></i>
            <p class="mb-0">You have no purchases yet.</p>
        </div>
    @else
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-success">
                <tr>
                    <th>Product</th>
                    <th>Price Paid</th>
                    <th>Quantity</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchases as $item)
                    <tr>
                        <td>{{ optional($item->product)->name ?? 'Deleted product' }}</td>
                        <td>${{ number_format($item->price_paid, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
