@extends('donor.layouts.dashboard')

@section('title', 'Settings - Donor Portal')

@push('styles')
<style>
    .icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }
    
    .card {
        transition: box-shadow 0.3s ease;
    }
    
    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    
    .form-label {
        font-weight: 500;
        color: #495057;
    }
    
    .btn-primary {
        background-color: #28a745;
        border-color: #28a745;
    }
    
    .btn-primary:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }
    
    .section-divider {
        border-top: 1px solid #e9ecef;
        margin: 2rem 0;
    }
</style>
@endpush

@section('header', 'Account Settings')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <!-- Profile Settings Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-primary-subtle text-primary me-3">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h2 class="h4 mb-0">Profile Settings</h2>
                            <p class="text-muted mb-0">Manage your account information and preferences</p>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <form action="#" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-medium">Full Name</label>
                                <input type="text" name="name" id="name" 
                                       class="form-control" 
                                       value="{{ Auth::guard('donor')->user()->name }}">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-medium">Email Address</label>
                                <input type="email" name="email" id="email" 
                                       class="form-control" 
                                       value="{{ Auth::guard('donor')->user()->email }}">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-medium">Phone Number</label>
                                <input type="tel" name="phone" id="phone" 
                                       class="form-control" 
                                       value="{{ Auth::guard('donor')->user()->phone ?? '' }}">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="address" class="form-label fw-medium">Address</label>
                                <input type="text" name="address" id="address" 
                                       class="form-control" 
                                       value="{{ Auth::guard('donor')->user()->address ?? '' }}">
                            </div>
                        </div>
                        
                        <div class="section-divider"></div>
                        
                        <!-- Security Settings -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-4">
                                <div class="icon-circle bg-warning-subtle text-warning me-3">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <div>
                                    <h3 class="h5 mb-0 fw-bold text-dark">Security Settings</h3>
                                    <p class="text-muted mb-0">Update your password and security preferences</p>
                                </div>
                            </div>
                            
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="current_password" class="form-label fw-medium">Current Password</label>
                                    <input type="password" name="current_password" id="current_password" 
                                           class="form-control">
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="new_password" class="form-label fw-medium">New Password</label>
                                    <input type="password" name="new_password" id="new_password" 
                                           class="form-control">
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="confirm_password" class="form-label fw-medium">Confirm New Password</label>
                                    <input type="password" name="confirm_password" id="confirm_password" 
                                           class="form-control">
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-light">
                                <i class="fas fa-times me-1"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Notification Preferences Card -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-info-subtle text-info me-3">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div>
                            <h2 class="h4 mb-0">Notification Preferences</h2>
                            <p class="text-muted mb-0">Choose how you want to be notified</p>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="mb-4">
                        <h3 class="h5 fw-bold text-dark mb-3">Email Notifications</h3>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="donation-confirmations" checked>
                                <label class="form-check-label fw-medium" for="donation-confirmations">
                                    Donation Confirmations
                                </label>
                                <p class="text-muted small mb-0">Get emails when your donations are processed</p>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="relief-updates" checked>
                                <label class="form-check-label fw-medium" for="relief-updates">
                                    Relief Updates
                                </label>
                                <p class="text-muted small mb-0">Receive updates on relief operations you've contributed to</p>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="newsletters">
                                <label class="form-check-label fw-medium" for="newsletters">
                                    Newsletters
                                </label>
                                <p class="text-muted small mb-0">Monthly newsletters about our work and impact</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary">
                            <i class="fas fa-sync-alt me-1"></i> Update Preferences
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection