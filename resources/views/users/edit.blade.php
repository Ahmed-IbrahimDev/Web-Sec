@extends('app')

@section('title', 'Edit User Roles')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0"><i class="fas fa-user-tag me-2"></i>Edit Roles for {{ $user->name }}</h1>
        <a href="{{ route('permissions') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Permissions
        </a>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>Please correct the following errors:
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-user-shield me-2"></i>Assign Roles</h5>
        </div>
        
        <div class="card-body p-4">
            <form action="{{ route('users.roles.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4 p-3 bg-light rounded">
                    <h6 class="mb-3 text-primary"><i class="fas fa-user-circle me-2"></i>User Information</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <span class="text-secondary">Name:</span>
                                <span class="fw-bold ms-2">{{ $user->name }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <span class="text-secondary">Email:</span>
                                <span class="fw-bold ms-2">{{ $user->email }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6 class="mb-3 text-primary"><i class="fas fa-key me-2"></i>Assign Roles</h6>
                    <div class="row g-3">
                        @foreach($roles as $role)
                            <div class="col-md-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input type="checkbox" 
                                                   class="form-check-input" 
                                                   id="role_{{ $role->id }}" 
                                                   name="roles[]" 
                                                   value="{{ $role->id }}" 
                                                   {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold" for="role_{{ $role->id }}">{{ $role->name }}</label>
                                        </div>
                                        <p class="small text-muted mt-2 mb-0">{{ $role->description }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Update Roles
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection