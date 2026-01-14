@extends('admin.layouts.app')

@section('title', 'Edit Area')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary">Edit Area: {{ $area->name }}</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('admin.areas.update', $area) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Name -->
                        <div class="form-group">
                            <label for="name">Area Name *</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $area->name) }}" placeholder="e.g., Barangay 123, Evacuation Center A" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Code -->
                        <div class="form-group">
                            <label for="code">Area Code *</label>
                            <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" 
                                   value="{{ old('code', $area->code) }}" placeholder="e.g., BRG123, EVACA" maxlength="10" required>
                            <small class="form-text text-muted">Unique identifier for the area (max 10 characters).</small>
                            @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" rows="3" 
                                      class="form-control @error('description') is-invalid @enderror" 
                                      placeholder="Brief description of the area...">{{ old('description', $area->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="is_active" id="is_active" class="custom-control-input" value="1" 
                                       {{ $area->is_active ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">
                                    Active
                                </label>
                                <small class="form-text text-muted">Inactive areas won't be available for distributions.</small>
                            </div>
                        </div>

                        <!-- Area Statistics -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">Area Statistics</h6>
                                        <p class="card-text">
                                            <strong>Distributions:</strong> {{ $area->distributions()->count() }}<br>
                                            <strong>Relief Requests:</strong> {{ $area->reliefRequests()->count() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">Created Information</h6>
                                        <p class="card-text">
                                            <strong>Created:</strong> {{ $area->created_at->format('M d, Y h:i A') }}<br>
                                            <strong>Last Updated:</strong> {{ $area->updated_at->format('M d, Y h:i A') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Update Area
                            </button>
                            <a href="{{ route('admin.areas.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times mr-1"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-format code to uppercase
    document.getElementById('code').addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
</script>
@endpush
