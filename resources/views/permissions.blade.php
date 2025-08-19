@extends('app')

@section('title', 'Permissions Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-shield me-2"></i>Permissions Management
        </h1>
        <div>
            @if(Auth::user()->isAdmin())
                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                    <i class="fas fa-plus-circle me-2"></i>Create New Role
                </button>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>Please fix the following errors:
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- System Overview -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-gradient-primary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-info-circle me-2"></i>System Overview
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                <i class="fas fa-crown fa-3x text-warning mb-2"></i>
                                <h6 class="text-primary">Super Admin</h6>
                                <p class="small text-muted">Full system access<br>Can delete admins</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <i class="fas fa-user-shield fa-3x text-info mb-2"></i>
                                <h6 class="text-primary">Admins</h6>
                                <p class="small text-muted">Product & user management<br>Cannot delete admins</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <i class="fas fa-user fa-3x text-success mb-2"></i>
                                <h6 class="text-primary">Regular Users</h6>
                                <p class="small text-muted">Catalog access only<br>View and purchase</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <i class="fas fa-lock fa-3x text-secondary mb-2"></i>
                                <h6 class="text-primary">Security</h6>
                                <p class="small text-muted">Role-based access<br>Protected operations</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Roles Section -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 bg-gradient-primary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-user-tag me-2"></i>Roles & Permissions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>Role Name</th>
                                    <th>Description</th>
                                    <th>Key Permissions</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roles as $role)
                                    <tr>
                                        <td>
                                            <strong>
                                                @if($role->name === 'super_admin')
                                                    <i class="fas fa-crown text-warning me-1"></i>
                                                @elseif($role->name === 'employee')
                                                    <i class="fas fa-user-shield text-info me-1"></i>
                                                @else
                                                    <i class="fas fa-user text-success me-1"></i>
                                                @endif
                                                {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                            </strong>
                                        </td>
                                        <td>{{ $role->description }}</td>
                                        <td>
                                            @php
                                                $keyPermissions = [];
                                                if($role->name === 'super_admin') {
                                                    $keyPermissions = ['All Permissions', 'Delete Admins', 'System Management'];
                                                } elseif($role->name === 'employee') {
                                                    $keyPermissions = ['Product Management', 'User Management', 'No Delete Admins'];
                                                } else {
                                                    $keyPermissions = ['Catalog Access Only'];
                                                }
                                            @endphp
                                            @foreach($keyPermissions as $permission)
                                                <span class="badge bg-info me-1">{{ $permission }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-info me-1">
                                                <i class="fas fa-edit me-1"></i>Edit
                                            </a>
                                            @if($role->name !== 'super_admin')
                                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Are you sure you want to delete this role?')">
                                                        <i class="fas fa-trash me-1"></i>Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            <i class="fas fa-info-circle fa-2x mb-3"></i>
                                            <p>No roles defined</p>
                                            <a href="{{ route('roles.create') }}" class="btn btn-sm btn-primary">Create First Role</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Section -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 bg-gradient-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-users me-2"></i>Users & Roles
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-success">
                                <tr>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                            </strong>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @forelse($user->roles as $role)
                                                @switch($role->name)
                                                    @case('super_admin')
                                                        <span class="badge bg-warning me-1">
                                                            <i class="fas fa-crown me-1"></i>Super Admin
                                                        </span>
                                                        @break
                                                    @case('employee')
                                                        <span class="badge bg-info me-1">
                                                            <i class="fas fa-user-shield me-1"></i>Employee
                                                        </span>
                                                        @break
                                                    @case('owner')
                                                        <span class="badge bg-primary me-1">
                                                            <i class="fas fa-star me-1"></i>Owner
                                                        </span>
                                                        @break
                                                    @case('custmer')
                                                        <span class="badge bg-success me-1">
                                                            <i class="fas fa-user me-1"></i>Custmer
                                                        </span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary me-1">
                                                            <i class="fas fa-tag me-1"></i>{{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                                        </span>
                                                @endswitch
                                            @empty
                                                <span class="text-muted">No roles assigned</span>
                                            @endforelse
                                        </td>
                                        <td>
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-user-edit me-1"></i>Edit Roles
                                            </a>

                                            @php
                                                $currentUser = Auth::user();
                                                $canDelete = false;
                                                if ($currentUser->id !== $user->id) { // Can't delete self
                                                    if ($currentUser->hasRole('super_admin') && !$user->hasRole('super_admin')) {
                                                        $canDelete = true;
                                                    } elseif ($currentUser->hasRole('employee') && !$user->hasRole('super_admin') && !$user->hasRole('employee')) {
                                                        $canDelete = true;
                                                    }
                                                }
                                            @endphp

                                            @if($canDelete)
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash me-1"></i>Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            <i class="fas fa-users fa-2x mb-3"></i>
                                            <p>No users found</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Available Permissions -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3 bg-gradient-info text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-key me-2"></i>Available Permissions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($permissions as $permission)
                            <div class="col-md-3 mb-3">
                                <div class="card border-info">
                                    <div class="card-body text-center">
                                        <i class="fas fa-shield-alt fa-2x text-info mb-2"></i>
                                        <h6 class="card-title">{{ str_replace('_', ' ', ucfirst($permission->name)) }}</h6>
                                        <p class="card-text small text-muted">{{ $permission->description }}</p>
                                        @if(str_contains($permission->name, 'delete_admins') || str_contains($permission->name, 'manage_system'))
                                            <span class="badge bg-warning">Super Admin Only</span>
                                        @elseif(str_contains($permission->name, 'view_products'))
                                            <span class="badge bg-success">All Users</span>
                                        @else
                                            <span class="badge bg-info">Admin+</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-gradient-secondary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-bolt me-2"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <a href="http://127.0.0.1:8000/create_super_admin_system.php" class="btn btn-warning w-100">
                                <i class="fas fa-crown me-2"></i>Setup Super Admin
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('products') }}" class="btn btn-primary w-100">
                                <i class="fas fa-box me-2"></i>Manage Products
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('catalog') }}" class="btn btn-success w-100">
                                <i class="fas fa-th-list me-2"></i>View Catalog
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('dashboard') }}" class="btn btn-info w-100">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 