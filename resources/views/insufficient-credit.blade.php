@extends('app')

@section('title', 'Insufficient Credit')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="fas fa-times-circle me-2"></i>Insufficient Credit</h5>
                </div>
                <div class="card-body">
                    <p class="lead">You don't have enough credit to buy: <strong>{{ $product->name }}</strong></p>
                    <ul class="list-unstyled">
                        <li>Price: <strong>${{ number_format($requiredAmount, 2) }}</strong></li>
                        <li>Your credit: <strong>${{ number_format($userCredit, 2) }}</strong></li>
                        <li>Needed: <strong>${{ number_format(max(0, $requiredAmount - $userCredit), 2) }}</strong></li>
                    </ul>
                    <div class="d-flex gap-2">
                        <a href="{{ route('catalog') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Back to Catalog</a>
                        <a href="{{ route('dashboard') }}" class="btn btn-primary"><i class="fas fa-tachometer-alt me-1"></i>Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
