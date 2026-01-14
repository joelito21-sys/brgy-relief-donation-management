@extends('donor.layouts.dashboard')

@section('title', 'Medicine Donation - Barangay Cubacub Relief and Donation Management Program')

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
    
    .text-danger {
        color: #dc3545 !important;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }
</style>
@endpush

@section('header', 'Medicine Donation')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h2 class="h4 mb-1">Medicine Donation Request</h2>
                    <p class="text-muted mb-0">Please provide details about the medicine you wish to donate.</p>
                </div>

                <form action="{{ route('donor.donations.medicine.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    
                    <div class="card-body">
                        <!-- Medicine Information Section -->
                        <div class="mb-5">
                            <div class="d-flex align-items-center mb-4">
                                <div class="icon-circle bg-primary-subtle text-primary me-3">
                                    <i class="fas fa-pills"></i>
                                </div>
                                <h3 class="h5 mb-0 fw-bold text-dark">Medicine Information</h3>
                            </div>
                            
                            <div class="row g-3">
                                <!-- Medicine Name -->
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-medium">Medicine Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" required class="form-control">
                                    <div class="invalid-feedback">Please enter the medicine name.</div>
                                </div>
                                
                                <!-- Quantity -->
                                <div class="col-md-6">
                                    <label for="quantity" class="form-label fw-medium">Quantity <span class="text-danger">*</span></label>
                                    <input type="number" name="quantity" id="quantity" min="1" required class="form-control">
                                    <div class="invalid-feedback">Please enter a valid quantity.</div>
                                </div>
                                
                                <!-- Expiry Date -->
                                <div class="col-md-6">
                                    <label for="expiry_date" class="form-label fw-medium">Expiry Date <span class="text-danger">*</span></label>
                                    <input type="date" name="expiry_date" id="expiry_date" required min="{{ now()->format('Y-m-d') }}" class="form-control">
                                    <div class="invalid-feedback">Please enter a valid expiry date.</div>
                                </div>
                                
                                <!-- Condition -->
                                <div class="col-md-6">
                                    <label for="condition" class="form-label fw-medium">Condition <span class="text-danger">*</span></label>
                                    <select id="condition" name="condition" required class="form-select">
                                        <option value="">Select condition</option>
                                        <option value="sealed">Sealed/Unopened</option>
                                        <option value="unsealed">Unsealed/Partially Used</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a condition.</div>
                                </div>
                                
                                <!-- Prescription Required -->
                                <div class="col-md-12">
                                    <label class="form-label fw-medium">Prescription Required</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="requires_prescription" id="prescription-yes" value="1">
                                            <label class="form-check-label" for="prescription-yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="requires_prescription" id="prescription-no" value="0" checked>
                                            <label class="form-check-label" for="prescription-no">No</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Special Instructions -->
                                <div class="col-12">
                                    <label for="special_instructions" class="form-label fw-medium">Special Instructions</label>
                                    <textarea id="special_instructions" name="special_instructions" rows="3" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Donor Information Section -->
                        <div class="mb-5 pt-4 border-top">
                            <div class="d-flex align-items-center mb-4">
                                <div class="icon-circle bg-success-subtle text-success me-3">
                                    <i class="fas fa-user"></i>
                                </div>
                                <h3 class="h5 mb-0 fw-bold text-dark">Your Information</h3>
                            </div>
                            
                            <div class="row g-3">
                                <!-- Name -->
                                <div class="col-md-6">
                                    <label for="donor_name" class="form-label fw-medium">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="donor_name" id="donor_name" required value="{{ auth('donor')->user()->name }}" class="form-control">
                                    <div class="invalid-feedback">Please enter your full name.</div>
                                </div>
                                
                                <!-- Email -->
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-medium">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" required value="{{ auth('donor')->user()->email }}" class="form-control">
                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                </div>
                                
                                <!-- Phone -->
                                <div class="col-md-6">
                                    <label for="phone" class="form-label fw-medium">Phone Number <span class="text-danger">*</span></label>
                                    <input type="tel" name="phone" id="phone" required value="{{ auth('donor')->user()->phone ?? '' }}" class="form-control">
                                    <div class="invalid-feedback">Please enter your phone number.</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Delivery Information Section -->
                        <div class="mb-5 pt-4 border-top">
                            <div class="d-flex align-items-center mb-4">
                                <div class="icon-circle bg-info-subtle text-info me-3">
                                    <i class="fas fa-truck"></i>
                                </div>
                                <h3 class="h5 mb-0 fw-bold text-dark">Delivery Information</h3>
                            </div>
                            
                            <div class="row g-3">
                                <!-- Delivery Method -->
                                <div class="col-md-6">
                                    <label for="delivery_method" class="form-label fw-medium">Delivery Method <span class="text-danger">*</span></label>
                                    <select id="delivery_method" name="delivery_method" required class="form-select">
                                        <option value="dropoff">I will drop off</option>
                                        <option value="pickup">Request for pickup</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a delivery method.</div>
                                </div>
                                
                                <!-- Preferred Delivery/Pickup Date -->
                                <div class="col-md-6">
                                    <label for="preferred_date" class="form-label fw-medium">Preferred Date <span class="text-danger">*</span></label>
                                    <input type="date" name="preferred_date" id="preferred_date" required min="{{ now()->addDays(1)->format('Y-m-d') }}" class="form-control">
                                    <div class="invalid-feedback">Please select a preferred date.</div>
                                </div>
                                
                                <!-- Delivery Address (shown if pickup is selected) -->
                                <div class="col-md-12 d-none" id="delivery_address_container">
                                    <label for="delivery_address" class="form-label fw-medium">Pickup/Drop-off Address <span class="text-danger">*</span></label>
                                    <textarea id="delivery_address" name="delivery_address" rows="2" class="form-control" placeholder="Please provide the full address..."></textarea>
                                    <div class="invalid-feedback">Please enter the delivery address.</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Terms and Conditions -->
                        <div class="border rounded p-4 mb-4 bg-light">
                            <div class="form-check mb-3">
                                <input id="terms" name="terms" type="checkbox" required class="form-check-input">
                                <label for="terms" class="form-check-label fw-medium">I agree to the terms and conditions <span class="text-danger">*</span></label>
                                <div class="invalid-feedback">You must agree to the terms and conditions.</div>
                            </div>
                            <p class="text-muted mb-0">I confirm that all medicines are unexpired and properly stored. I understand that items not meeting quality standards may be safely disposed of.</p>
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="card-footer bg-white border-top text-end">
                        <a href="{{ route('donor.donations.index') }}" class="btn btn-light me-2">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i> Submit Donation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Show/hide delivery address based on delivery method
    document.getElementById('delivery_method').addEventListener('change', function() {
        const deliveryAddressContainer = document.getElementById('delivery_address_container');
        if (this.value === 'pickup') {
            deliveryAddressContainer.classList.remove('d-none');
            document.getElementById('delivery_address').required = true;
        } else {
            deliveryAddressContainer.classList.add('d-none');
            document.getElementById('delivery_address').required = false;
        }
    });
    
    // Set minimum date for preferred date (tomorrow)
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);
        
        const minDate = tomorrow.toISOString().split('T')[0];
        const dateInput = document.getElementById('preferred_date');
        if (dateInput) {
            dateInput.min = minDate;
            if (!dateInput.value) {
                dateInput.value = minDate;
            }
        }
        
        // Set minimum date for expiry dates
        const expiryInput = document.getElementById('expiry_date');
        if (expiryInput) {
            expiryInput.min = today.toISOString().split('T')[0];
        }
    });
    
    // Form validation
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>
@endpush
@endsection