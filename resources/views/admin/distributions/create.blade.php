@extends('admin.layouts.app')

@section('title', 'Create Distribution')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary">Create New Distribution</h5>
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

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('admin.distributions.store') }}" method="POST" onsubmit="return validateDistributionForm()">
                        @csrf
                        
                        <!-- Distribution Type -->
                        <div class="form-group">
                            <label for="distribution_type">Distribution Type *</label>
                            <select name="distribution_type" id="distribution_type" class="form-control @error('distribution_type') is-invalid @enderror" required>
                                <option value="">-- Select Distribution Type --</option>
                                <option value="general" {{ old('distribution_type') == 'general' ? 'selected' : 'selected' }}>General Distribution</option>
                                <option value="specific" {{ old('distribution_type') == 'specific' ? 'selected' : '' }}>Specific Request</option>
                            </select>
                            @error('distribution_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Title -->
                        <div class="form-group">
                            <label for="title">Distribution Title *</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title') }}" placeholder="e.g., Emergency Food Distribution" required>
                            @error('title')
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
                                      placeholder="Provide details about the distribution items and requirements">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Specific Request Selection (shown only for specific distribution) -->
                        <div id="specific-request-fields" style="display: none;">
                            <div class="form-group">
                                <label for="relief_request_id">Select Relief Request *</label>
                                <select name="relief_request_id" id="relief_request_id" class="form-control @error('relief_request_id') is-invalid @enderror">
                                    <option value="">-- Select Relief Request --</option>
                                    @forelse($requests as $request)
                                        <option value="{{ $request->id }}" {{ old('relief_request_id') == $request->id ? 'selected' : '' }}>
                                            {{ $request->request_number }} - {{ $request->user->name }} ({{ ucfirst($request->status) }})
                                        </option>
                                    @empty
                                        <option value="" disabled>No approved requests available for distribution</option>
                                    @endforelse
                                </select>
                                @error('relief_request_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- General Distribution Fields (shown only for general distribution) -->
                        <div id="general-distribution-fields" style="display: none;">
                            <div class="form-group">
                                <label for="area_id">Target Area *</label>
                                @if($areas->count() > 0)
                                    <select name="area_id" id="area_id" class="form-control @error('area_id') is-invalid @enderror">
                                        <option value="">-- Select Area --</option>
                                        @foreach($areas as $area)
                                            <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>
                                                {{ $area->name }} - {{ $area->description }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>
                                        <strong>No areas configured!</strong> Please 
                                        <a href="{{ route('admin.areas.create') }}" class="alert-link">create areas first</a> 
                                        or use specific distribution type.
                                    </div>
                                    <input type="text" name="area_name" id="area_name" class="form-control" 
                                           placeholder="Enter area name (temporary)" disabled>
                                @endif
                                @error('area_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Schedule and Location -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="scheduled_for">Scheduled Date & Time *</label>
                                    <input type="datetime-local" name="scheduled_for" id="scheduled_for" 
                                           class="form-control @error('scheduled_for') is-invalid @enderror" 
                                           value="{{ old('scheduled_for', now()->addDay()->format('Y-m-d\TH:i')) }}" required>
                                    @error('scheduled_for')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="location">Location *</label>
                                    <input type="text" name="location" id="location" class="form-control @error('location') is-invalid @enderror" 
                                           value="{{ old('location') }}" placeholder="e.g., Barangay Hall, Evacuation Center" required>
                                    @error('location')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <label for="status">Status *</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="">-- Select Status --</option>
                                <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Notify Residents -->
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="notify_residents" id="notify_residents" class="custom-control-input" value="1" checked>
                                <label class="custom-control-label" for="notify_residents">
                                    Notify all residents in the target area
                                </label>
                                <small class="form-text text-muted">This will create an alert notification for residents</small>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="form-group">
                            <label for="notes">Internal Notes</label>
                            <textarea name="notes" id="notes" rows="3" 
                                      class="form-control @error('notes') is-invalid @enderror" 
                                      placeholder="Internal notes for staff (not visible to residents)">{{ old('notes') }}</textarea>
                            @error('notes')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Create Distribution
                            </button>
                            <a href="{{ route('admin.distributions.index') }}" class="btn btn-secondary">
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
    // Toggle form fields based on distribution type
    function toggleDistributionFields() {
        const specificFields = document.getElementById('specific-request-fields');
        const generalFields = document.getElementById('general-distribution-fields');
        const notifyCheckbox = document.getElementById('notify_residents');
        const distributionType = document.getElementById('distribution_type').value;
        
        if (distributionType === 'specific') {
            specificFields.style.display = 'block';
            generalFields.style.display = 'none';
            document.getElementById('relief_request_id').setAttribute('required', '');
            document.getElementById('area_id').removeAttribute('required');
            notifyCheckbox.checked = false;
            notifyCheckbox.disabled = true;
        } else if (distributionType === 'general') {
            specificFields.style.display = 'none';
            generalFields.style.display = 'block';
            document.getElementById('relief_request_id').removeAttribute('required');
            document.getElementById('area_id').setAttribute('required', '');
            notifyCheckbox.checked = true;
            notifyCheckbox.disabled = false;
        } else {
            specificFields.style.display = 'none';
            generalFields.style.display = 'none';
            document.getElementById('relief_request_id').removeAttribute('required');
            document.getElementById('area_id').removeAttribute('required');
            notifyCheckbox.checked = false;
            notifyCheckbox.disabled = true;
        }
    }
    
    document.getElementById('distribution_type').addEventListener('change', toggleDistributionFields);
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleDistributionFields();
    });
    
    // Form validation
    function validateDistributionForm() {
        const distributionType = document.getElementById('distribution_type').value;
        
        if (!distributionType) {
            alert('Please select a distribution type.');
            return false;
        }
        
        if (distributionType === 'general') {
            const areaId = document.getElementById('area_id').value;
            if(areaId) {
                if (!areaId) {
                    alert('Please select a target area for general distribution.');
                    return false;
                }
            }
        }
        
        if (distributionType === 'specific') {
            const reliefRequestId = document.getElementById('relief_request_id').value;
            if (!reliefRequestId) {
                alert('Please select a relief request for specific distribution.');
                return false;
            }
        }
        
        return true;
    }

    // Set minimum datetime to current time
    const now = new Date();
    const offset = now.getTimezoneOffset() * 60000;
    const localISOTime = new Date(now - offset).toISOString().slice(0, 16);
    document.getElementById('scheduled_for').min = localISOTime;
</script>
@endpush
