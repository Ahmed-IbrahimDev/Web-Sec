@extends('app')

@section('title', 'Dashboard')

@section('styles')
<style>
    body {
        background-color: #f8f9fc;
        font-family: 'Nunito', sans-serif;
    }
    
    .dashboard-container {
        padding: 0;
        margin: 0;
    }
    
    .main-content {
        margin-left: 0;
        padding: 20px;
    }
    
    .dashboard-header {
        background: white;
        padding: 20px 30px;
        border-bottom: 1px solid #e3e6f0;
        margin-bottom: 30px;
    }
    
    .dashboard-title {
        font-size: 28px;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
    }
    
    /* Modern Stat Cards */
    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        border: none;
        transition: transform 0.2s ease;
        height: 100%;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.12);
    }
    
    .stat-number {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 5px;
    }
    
    .stat-label {
        font-size: 14px;
        color: #6c757d;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: white;
    }
    
    .stat-accepted { color: #10b981; }
    .stat-accepted .stat-icon { background: linear-gradient(135deg, #10b981, #059669); }
    
    .stat-contract { color: #f59e0b; }
    .stat-contract .stat-icon { background: linear-gradient(135deg, #f59e0b, #d97706); }
    
    .stat-approval { color: #ef4444; }
    .stat-approval .stat-icon { background: linear-gradient(135deg, #ef4444, #dc2626); }
    
    .stat-total { color: #6366f1; }
    .stat-total .stat-icon { background: linear-gradient(135deg, #6366f1, #4f46e5); }
    
    /* Chart Cards */
    .chart-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        border: none;
        margin-bottom: 30px;
    }
    
    .chart-header {
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e3e6f0;
    }
    
    .chart-title {
        font-size: 18px;
        font-weight: 600;
        color: #2c3e50;
        margin: 0;
    }
    
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }
    
    /* Contract Type Progress Bars */
    .contract-type-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .contract-type-label {
        font-weight: 500;
        color: #374151;
    }
    
    .contract-type-percentage {
        font-weight: 600;
        color: #6b7280;
    }
    
    .progress-custom {
        height: 8px;
        border-radius: 10px;
        background-color: #f3f4f6;
        margin-top: 5px;
    }
    
    .progress-bar-custom {
        height: 100%;
        border-radius: 10px;
        transition: width 0.6s ease;
    }
    
    /* Recent Contracts Table */
    .contracts-table {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }
    
    .table-header {
        background: #f8f9fc;
        padding: 20px 25px;
        border-bottom: 1px solid #e3e6f0;
    }
    
    .table-title {
        font-size: 18px;
        font-weight: 600;
        color: #2c3e50;
        margin: 0;
    }
    
    .custom-table {
        margin: 0;
    }
    
    .custom-table th {
        background: #f8f9fc;
        border: none;
        padding: 15px 25px;
        font-weight: 600;
        color: #6b7280;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .custom-table td {
        padding: 15px 25px;
        border: none;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-active { background: #dcfce7; color: #166534; }
    .status-draft { background: #fef3c7; color: #92400e; }
    .status-review { background: #dbeafe; color: #1e40af; }
    
    /* Average Cycle Time Cards */
    .cycle-time-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 20px;
    }
    
    .cycle-time-number {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 5px;
    }
    
    .cycle-time-label {
        font-size: 12px;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .cycle-time-sublabel {
        font-size: 14px;
        color: #374151;
        font-weight: 500;
    }
</style>
@endsection

@section('content')
<div class="dashboard-container">
    <div class="main-content">
        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <h1 class="dashboard-title">Dashboard</h1>
        </div>

        @if ($isSuperAdmin || $isAdmin)
            <!-- Modern Stat Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stat-card stat-accepted">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stat-number">2,340</div>
                                <div class="stat-label">Accepted</div>
                            </div>
                            <div class="stat-icon">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stat-card stat-contract">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stat-number">1,782</div>
                                <div class="stat-label">In Contract</div>
                            </div>
                            <div class="stat-icon">
                                <i class="fas fa-file-contract"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stat-card stat-approval">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stat-number">1,596</div>
                                <div class="stat-label">In Approval</div>
                            </div>
                            <div class="stat-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stat-card stat-total">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stat-number">{{ $totalUsers }}</div>
                                <div class="stat-label">Total Users</div>
                            </div>
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Analytics Row -->
            <div class="row">
                <!-- Contract by Stages Chart -->
                <div class="col-xl-4 col-lg-6 mb-4">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h6 class="chart-title">Contract by Stages</h6>
                        </div>
                        <div class="chart-container">
                            <canvas id="contractStagesChart"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Contract Expiring Chart -->
                <div class="col-xl-4 col-lg-6 mb-4">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h6 class="chart-title">Contract Expiring</h6>
                        </div>
                        <div class="chart-container">
                            <canvas id="contractExpiringChart"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Contract by Type -->
                <div class="col-xl-4 col-lg-12 mb-4">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h6 class="chart-title">Contract by Type</h6>
                        </div>
                        <div class="contract-types-list">
                            <div class="contract-type-item">
                                <span class="contract-type-label">NDA</span>
                                <span class="contract-type-percentage">70%</span>
                            </div>
                            <div class="progress-custom">
                                <div class="progress-bar-custom" style="width: 70%; background: #10b981;"></div>
                            </div>
                            
                            <div class="contract-type-item">
                                <span class="contract-type-label">Insurance</span>
                                <span class="contract-type-percentage">25%</span>
                            </div>
                            <div class="progress-custom">
                                <div class="progress-bar-custom" style="width: 25%; background: #f59e0b;"></div>
                            </div>
                            
                            <div class="contract-type-item">
                                <span class="contract-type-label">Lease</span>
                                <span class="contract-type-percentage">50%</span>
                            </div>
                            <div class="progress-custom">
                                <div class="progress-bar-custom" style="width: 50%; background: #6366f1;"></div>
                            </div>
                            
                            <div class="contract-type-item">
                                <span class="contract-type-label">Maintenance</span>
                                <span class="contract-type-percentage">65%</span>
                            </div>
                            <div class="progress-custom">
                                <div class="progress-bar-custom" style="width: 65%; background: #10b981;"></div>
                            </div>
                            
                            <div class="contract-type-item">
                                <span class="contract-type-label">Purchase Agreement</span>
                                <span class="contract-type-percentage">12%</span>
                            </div>
                            <div class="progress-custom">
                                <div class="progress-bar-custom" style="width: 12%; background: #ef4444;"></div>
                            </div>
                            
                            <div class="contract-type-item">
                                <span class="contract-type-label">Sale</span>
                                <span class="contract-type-percentage">10%</span>
                            </div>
                            <div class="progress-custom">
                                <div class="progress-bar-custom" style="width: 10%; background: #8b5cf6;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Contracts and Cycle Time Row -->
            <div class="row">
                <!-- Recent Contracts Table -->
                <div class="col-xl-8 col-lg-7 mb-4">
                    <div class="contracts-table">
                        <div class="table-header">
                            <h6 class="table-title">My Contracts</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table custom-table">
                                <thead>
                                    <tr>
                                        <th>SERIAL #</th>
                                        <th>NAME</th>
                                        <th>VALUE</th>
                                        <th>STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($recentProducts) && $recentProducts->count() > 0)
                                        @foreach($recentProducts->take(5) as $product)
                                        <tr>
                                            <td><strong>CNTR{{ str_pad($product->id, 6, '0', STR_PAD_LEFT) }}</strong></td>
                                            <td>{{ $product->name }}</td>
                                            <td><strong>${{ number_format($product->price, 0) }}</strong></td>
                                            <td><span class="status-badge status-active">Active</span></td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td><strong>CNTR000001</strong></td>
                                            <td>HorizonTech</td>
                                            <td><strong>$48,292</strong></td>
                                            <td><span class="status-badge status-active">Active</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>CNTR000002</strong></td>
                                            <td>FlowTech Labs</td>
                                            <td><strong>$20,550</strong></td>
                                            <td><span class="status-badge status-draft">Draft</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>CNTR000003</strong></td>
                                            <td>ServerTech INC.</td>
                                            <td><strong>$72,402</strong></td>
                                            <td><span class="status-badge status-review">In Review</span></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Average Cycle Time -->
                <div class="col-xl-4 col-lg-5 mb-4">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h6 class="chart-title">Average Cycle Time</h6>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="cycle-time-card">
                                    <div class="cycle-time-number text-success">25</div>
                                    <div class="cycle-time-label">DAYS</div>
                                    <div class="cycle-time-sublabel">NDA</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="cycle-time-card">
                                    <div class="cycle-time-number text-warning">45</div>
                                    <div class="cycle-time-label">DAYS</div>
                                    <div class="cycle-time-sublabel">Insurance</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="cycle-time-card">
                                    <div class="cycle-time-number text-info">18</div>
                                    <div class="cycle-time-label">DAYS</div>
                                    <div class="cycle-time-sublabel">Lease</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="cycle-time-card">
                                    <div class="cycle-time-number text-primary">12</div>
                                    <div class="cycle-time-label">DAYS</div>
                                    <div class="cycle-time-sublabel">Purchase</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @else
            {{-- Regular User Dashboard --}}
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="chart-card text-center">
                        <h6 class="chart-title mb-4">Welcome!</h6>
                        <p>Welcome to your dashboard. Here you can manage your profile and browse our products.</p>
                        <a href="{{ route('catalog') }}" class="btn btn-primary">
                            <i class="fas fa-shopping-cart mr-2"></i>Browse Catalog ({{ $totalProducts }} items)
                        </a>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection

@section('scripts')
@if ($isSuperAdmin || $isAdmin)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Contract by Stages Chart (Bar Chart)
    var ctx1 = document.getElementById('contractStagesChart').getContext('2d');
    var contractStagesChart = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['Active', 'Draft', 'Expired', 'Cancelled'],
            datasets: [{
                data: [150, 100, 75, 50],
                backgroundColor: ['#10b981', '#f59e0b', '#ef4444', '#6b7280'],
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Contract Expiring Chart (Donut Chart)
    var ctx2 = document.getElementById('contractExpiringChart').getContext('2d');
    var contractExpiringChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Within 60 days', 'Within 30 days', 'Expired'],
            datasets: [{
                data: [40, 35, 25],
                backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                }
            }
        }
    });
</script>
@endif
@endsection
