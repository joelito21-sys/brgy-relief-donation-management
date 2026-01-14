@extends('donor.layouts.dashboard')

@section('title', 'Clothing Donation - Barangay Cubacub Relief and Donation Management Program')

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

@section('header', 'Clothing Donation')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h2 class="h4 mb-1">Clothing Donation Request</h2>
                    <p class="text-muted mb-0">Please provide details about the clothing items you wish to donate.</p>
                </div>

                <form action="{{ route('donor.donations.clothing.store') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                    @csrf
                    
                    <div class="card-body">
                        <!-- Clothing Items Section -->
                        <div class="mb-5">
                            <div class="d-flex align-items-center mb-4">
                                <div class="icon-circle bg-primary-subtle text-primary me-3">
                                    <i class="fas fa-tshirt"></i>
                                </div>
                                <h3 class="h5 mb-0 fw-bold text-dark">Clothing Items</h3>
                            </div>
                            
                            <div id="clothing-items-container">
                                <!-- Clothing Item 1 -->
                                <div class="clothing-item card mb-4 border">
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <!-- Clothing Type -->
                                            <div class="col-md-6 col-lg-4">
                                                <label class="form-label fw-medium">Type of Clothing <span class="text-danger">*</span></label>
                                                <select name="clothing_items[0][type]" required class="form-select">
                                                    <option value="">Select clothing type</option>
                                                    <option value="mens">Men's Clothing</option>
                                                    <option value="womens">Women's Clothing</option>
                                                    <option value="childrens">Children's Clothing</option>
                                                    <option value="infant">Infant Clothing</option>
                                                    <option value="footwear">Footwear</option>
                                                    <option value="outerwear">Outerwear</option>
                                                    <option value="accessories">Accessories</option>
                                                    <option value="other">Other</option>
                                                </select>
                                                <div class="invalid-feedback">Please select a clothing type.</div>
                                            </div>
                                            
                                            <!-- Size -->
                                            <div class="col-md-6 col-lg-4">
                                                <label class="form-label fw-medium">Size</label>
                                                <select name="clothing_items[0][size]" class="form-select">
                                                    <option value="">Select size</option>
                                                    <optgroup label="Women's">
                                                        <option value="womens_xs">XS</option>
                                                        <option value="womens_s">S</option>
                                                        <option value="womens_m">M</option>
                                                        <option value="womens_l">L</option>
                                                        <option value="womens_xl">XL</option>
                                                        <option value="womens_plus">Plus Size</option>
                                                    </optgroup>
                                                    <optgroup label="Men's">
                                                        <option value="mens_s">S</option>
                                                        <option value="mens_m">M</option>
                                                        <option value="mens_l">L</option>
                                                        <option value="mens_xl">XL</option>
                                                        <option value="mens_xxl">XXL</option>
                                                        <option value="mens_plus">Big & Tall</option>
                                                    </optgroup>
                                                    <optgroup label="Children's">
                                                        <option value="child_0_3m">0-3 months</option>
                                                        <option value="child_3_6m">3-6 months</option>
                                                        <option value="child_6_12m">6-12 months</option>
                                                        <option value="child_12_18m">12-18 months</option>
                                                        <option value="child_18_24m">18-24 months</option>
                                                        <option value="child_2t">2T</option>
                                                        <option value="child_3t">3T</option>
                                                        <option value="child_4t">4T</option>
                                                        <option value="child_5t">5T</option>
                                                        <option value="child_youth_s">Youth S (6-7)</option>
                                                        <option value="child_youth_m">Youth M (8-9)</option>
                                                        <option value="child_youth_l">Youth L (10-12)</option>
                                                    </optgroup>
                                                    <option value="one_size">One Size Fits All</option>
                                                    <option value="not_sure">Not Sure</option>
                                                </select>
                                            </div>
                                            
                                            <!-- Quantity -->
                                            <div class="col-md-6 col-lg-4">
                                                <label class="form-label fw-medium">Quantity <span class="text-danger">*</span></label>
                                                <input type="number" name="clothing_items[0][quantity]" min="1" required class="form-control">
                                                <div class="invalid-feedback">Please enter a valid quantity.</div>
                                            </div>
                                            
                                            <!-- Condition -->
                                            <div class="col-md-6 col-lg-4">
                                                <label class="form-label fw-medium">Condition <span class="text-danger">*</span></label>
                                                <select name="clothing_items[0][condition]" required class="form-select">
                                                    <option value="new_with_tags">New with Tags</option>
                                                    <option value="new_without_tags">New without Tags</option>
                                                    <option value="gently_used">Gently Used</option>
                                                    <option value="used_good">Used - Good Condition</option>
                                                    <option value="used_fair">Used - Fair Condition</option>
                                                </select>
                                                <div class="invalid-feedback">Please select a condition.</div>
                                            </div>
                                            
                                            <!-- Gender -->
                                            <div class="col-md-6 col-lg-4">
                                                <label class="form-label fw-medium">Gender</label>
                                                <select name="clothing_items[0][gender]" class="form-select">
                                                    <option value="">Unisex/Any</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                    <option value="boys">Boys</option>
                                                    <option value="girls">Girls</option>
                                                </select>
                                            </div>
                                            
                                            <!-- Season -->
                                            <div class="col-md-6 col-lg-4">
                                                <label class="form-label fw-medium">Season</label>
                                                <select name="clothing_items[0][season]" class="form-select">
                                                    <option value="all_season">All Season</option>
                                                    <option value="summer">Summer</option>
                                                    <option value="winter">Winter</option>
                                                    <option value="spring">Spring</option>
                                                    <option value="fall">Fall</option>
                                                </select>
                                            </div>
                                            
                                            <!-- Description -->
                                            <div class="col-12">
                                                <label class="form-label fw-medium">Description (e.g., color, style, brand)</label>
                                                <input type="text" name="clothing_items[0][description]" class="form-control" placeholder="E.g., Blue jeans, size 32x34, brand X">
                                            </div>
                                            
                                            <!-- Photo Upload -->
                                            <div class="col-12">
                                                <label class="form-label fw-medium">Photo (Optional)</label>
                                                <input type="file" name="clothing_items[0][photos][]" multiple class="form-control" accept="image/*">
                                                <div class="form-text">You can upload multiple photos (max 5MB each)</div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-3 text-end">
                                            <button type="button" class="btn btn-sm btn-outline-danger remove-clothing-item">
                                                <i class="fas fa-trash me-1"></i> Remove Item
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-2">
                                <button type="button" id="add-clothing-item" class="btn btn-outline-primary">
                                    <i class="fas fa-plus me-1"></i> Add Another Clothing Item
                                </button>
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
                                    <input type="text" name="name" id="donor_name" required value="{{ auth('donor')->user()->name }}" class="form-control">
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
                                
                                <!-- Organization (Optional) -->
                                <div class="col-md-6">
                                    <label for="organization" class="form-label fw-medium">Organization (Optional)</label>
                                    <input type="text" name="organization" id="organization" class="form-control">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Donation Details Section -->
                        <div class="mb-5 pt-4 border-top">
                            <div class="d-flex align-items-center mb-4">
                                <div class="icon-circle bg-info-subtle text-info me-3">
                                    <i class="fas fa-truck"></i>
                                </div>
                                <h3 class="h5 mb-0 fw-bold text-dark">Donation Details</h3>
                            </div>
                            
                            <div class="row g-3">
                                <!-- Donation Type -->
                                <div class="col-md-6">
                                    <label for="donation_type" class="form-label fw-medium">Donation Type <span class="text-danger">*</span></label>
                                    <select id="donation_type" name="donation_type" required class="form-select">
                                        <option value="individual">Individual Donation</option>
                                        <option value="clothing_drive">Clothing Drive</option>
                                        <option value="retailer">Retail/Wholesale</option>
                                        <option value="other">Other</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a donation type.</div>
                                </div>
                                
                                <!-- Preferred Pickup/Drop-off Date -->
                                <div class="col-md-6">
                                    <label for="preferred_date" class="form-label fw-medium">Preferred Date <span class="text-danger">*</span></label>
                                    <input type="date" name="preferred_date" id="preferred_date" required min="{{ now()->addDays(1)->format('Y-m-d') }}" class="form-control">
                                    <div class="invalid-feedback">Please select a preferred date.</div>
                                </div>
                                
                                <!-- Delivery Method -->
                                <div class="col-md-6">
                                    <label for="delivery_method" class="form-label fw-medium">Delivery Method <span class="text-danger">*</span></label>
                                    <select id="delivery_method" name="delivery_method" required class="form-select">
                                        <option value="dropoff">I will drop off</option>
                                        <option value="pickup">Request for pickup</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a delivery method.</div>
                                </div>
                                
                                <!-- Delivery Address -->
                                <div class="col-md-6" id="delivery_address_container">
                                    <label for="delivery_address" class="form-label fw-medium">Pickup/Drop-off Address <span class="text-danger">*</span></label>
                                    <textarea id="delivery_address" name="delivery_address" rows="2" required class="form-control" placeholder="Please provide the full address..."></textarea>
                                    <div class="invalid-feedback">Please enter the delivery address.</div>
                                </div>
                                
                                <!-- Special Instructions -->
                                <div class="col-12">
                                    <label for="special_instructions" class="form-label fw-medium">Special Instructions</label>
                                    <textarea id="special_instructions" name="special_instructions" rows="2" class="form-control" placeholder="Any special instructions for pickup/delivery..."></textarea>
                                </div>
                                
                                <!-- Receipt Needed -->
                                <div class="col-12">
                                    <div class="form-check">
                                        <input id="receipt_needed" name="receipt_needed" type="checkbox" class="form-check-input">
                                        <label for="receipt_needed" class="form-check-label fw-medium">I need a tax receipt for this donation</label>
                                    </div>
                                    <p class="text-muted small mb-0">A receipt will be emailed to you upon processing your donation.</p>
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
                            <p class="text-muted mb-0">I confirm that all clothing items are clean, in good condition, and appropriate for redistribution. I understand that items not meeting quality standards may be recycled or disposed of.</p>
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
    // Add new clothing item
    let clothingItemCount = 1;
    document.getElementById('add-clothing-item').addEventListener('click', function() {
        const container = document.getElementById('clothing-items-container');
        const newItem = document.querySelector('.clothing-item').cloneNode(true);
        
        // Update the index for the new item
        const newIndex = clothingItemCount++;
        newItem.innerHTML = newItem.innerHTML.replace(/\[0\]/g, `[${newIndex}]`);
        
        // Clear the values
        const inputs = newItem.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            if (input.type === 'radio' || input.type === 'checkbox') {
                input.checked = false;
            } else if (input.type !== 'button' && input.type !== 'file') {
                input.value = '';
            } else if (input.type === 'file') {
                input.value = '';
            }
        });
        
        // Add remove functionality
        const removeButton = newItem.querySelector('.remove-clothing-item');
        removeButton.addEventListener('click', function() {
            newItem.remove();
        });
        
        container.appendChild(newItem);
    });
    
    // Remove clothing item
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-clothing-item')) {
            const clothingItems = document.querySelectorAll('.clothing-item');
            if (clothingItems.length > 1) {
                e.target.closest('.clothing-item').remove();
            } else {
                alert('At least one clothing item is required.');
            }
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
    });
    
    // File upload validation
    document.addEventListener('change', function(e) {
        if (e.target.type === 'file') {
            const files = e.target.files;
            const maxSize = 5 * 1024 * 1024; // 5MB
            
            for (let i = 0; i < files.length; i++) {
                if (files[i].size > maxSize) {
                    alert('One or more files exceed the maximum file size of 5MB');
                    e.target.value = ''; // Clear the file input
                    break;
                }
                
                // Check file type (images only)
                const fileType = files[i].type;
                if (!fileType.startsWith('image/')) {
                    alert('Only image files are allowed');
                    e.target.value = ''; // Clear the file input
                    break;
                }
            }
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