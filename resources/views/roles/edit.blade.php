@extends('app')

@section('title', 'Edit Role')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Role: {{ $role->name }}</h1>
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
            <h5 class="mb-0"><i class="fas fa-shield-alt me-2"></i>Role Details</h5>
        </div>
        
        <div class="card-body p-4">
            <form action="{{ route('roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="name" class="form-label text-primary fw-bold"><i class="fas fa-tag me-2"></i>Role Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $role->name) }}" required>
                    </div>
                    <small class="form-text text-muted">Enter a unique name for this role</small>
                </div>
                
                <div class="mb-4">
                    <label for="description" class="form-label text-primary fw-bold"><i class="fas fa-align-left me-2"></i>Description</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $role->description) }}</textarea>
                    </div>
                    <small class="form-text text-muted">Provide a brief description of this role's purpose</small>
                </div>
                
                <div class="mb-4">
                    <label class="form-label text-primary fw-bold"><i class="fas fa-key me-2"></i>Permissions</label>
                    <div class="row g-3">
                        @foreach($permissions as $permission)
                            <div class="col-md-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input type="checkbox" 
                                                   class="form-check-input" 
                                                   id="permission_{{ $permission->id }}" 
                                                   name="permissions[]" 
                                                   value="{{ $permission->id }}" 
                                                   {{ in_array($permission->id, old('permissions', $role->permissions->pluck('id')->toArray())) ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold" for="permission_{{ $permission->id }}">{{ $permission->name }}</label>
                                        </div>
                                        <p class="small text-muted mt-2 mb-0">{{ $permission->description }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Update Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection