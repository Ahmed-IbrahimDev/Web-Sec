@extends('app')

@section('title', 'Dashboard')

@section('styles')
<style>
    .icon-circle {
        height: 3rem;
        width: 3rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    .card-body .h5 {
        color: #5a5c69;
    }
    .card.border-left-primary {
        border-left: .25rem solid #4e73df!important;
    }
    .card.border-left-success {
        border-left: .25rem solid #1cc88a!important;
    }
    .card.border-left-info {
        border-left: .25rem solid #36b9cc!important;
    }
    .card.border-left-warning {
        border-left: .25rem solid #f6c23e!important;
    }
    .chart-container {
        position: relative;
        height: 320px;
        width: 100%;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <span class="text-muted">Welcome back, {{ Auth::user()->name }}!</span>
    </div>

    @if ($isSuperAdmin || $isAdmin || $isOwner)
        {{-- Admin & Super Admin Dashboard --}}
        
        <!-- Stat Cards Row -->
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Users</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Products</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProducts }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-box-open fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Roles</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalRoles }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-tag fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Permissions</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPermissions }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-shield-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Quick Actions Row -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-cogs me-2"></i>Admin Management
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="text-center">
                                    <div class="dashboard-icon">
                                        <i class="fas fa-box text-success"></i>
                                    </div>
                                    <h5>Products</h5>
                                    <p class="text-muted">Manage product catalog</p>
                                    <a href="{{ route('products') }}" class="btn btn-success">
                                        <i class="fas fa-box me-1"></i> Manage Products
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="text-center">
                                    <div class="dashboard-icon">
                                        <i class="fas fa-user-lock text-warning"></i>
                                    </div>
                                    <h5>Permissions</h5>
                                    <p class="text-muted">Manage roles & permissions</p>
                                    <a href="{{ route('permissions') }}" class="btn btn-warning">
                                        <i class="fas fa-user-lock me-1"></i> Manage Permissions
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="text-center">
                                    <div class="dashboard-icon">
                                        <i class="fas fa-users text-info"></i>
                                    </div>
                                    <h5>Users</h5>
                                    <p class="text-muted">View user management</p>
                                    <a href="{{ route('permissions') }}" class="btn btn-info">
                                        <i class="fas fa-users me-1"></i> Manage Users
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Monthly User Registrations</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="userRegistrationChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Product Categories</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="productCategoriesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        {{-- Regular User Dashboard --}}
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Welcome!</h6>
                    </div>
                    <div class="card-body text-center">
                        <p>Welcome to your dashboard. Here you can manage your profile and browse our products.</p>
                        <a href="{{ route('catalog') }}" class="btn btn-primary">
                            <i class="fas fa-shopping-cart mr-2"></i>Browse Catalog ({{ $totalProducts }} items)
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection

@section('scripts')
@if ($isSuperAdmin || $isAdmin || $isOwner)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // User Registration Chart
    var ctx1 = document.getElementById('userRegistrationChart').getContext('2d');
    var userRegistrationChart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'New Users',
                data: [@foreach($monthlyUsers as $count) {{ $count }}, @endforeach],
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 2,
                pointRadius: 3,
                pointBackgroundColor: 'rgba(78, 115, 223, 1)'
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Product Categories Chart
    var ctx2 = document.getElementById('productCategoriesChart').getContext('2d');
    var productCategoriesChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: [@foreach($productCategories as $category => $count) '{{ $category }}', @endforeach],
            datasets: [{
                data: [@foreach($productCategories as $category => $count) {{ $count }}, @endforeach],
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endif
@endsection
