@extends('donor.layouts.dashboard')

@section('title', 'Food Donation - Barangay Cubacub Relief and Donation Management Program')

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
    
    .section-divider {
        border-top: 1px solid #e9ecef;
        margin: 2rem 0;
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

@section('header', 'Food Donation')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h2 class="h4 mb-1">Food Donation Request</h2>
                    <p class="text-muted mb-0">Please provide details about the food items you wish to donate.</p>
                </div>

                <form action="{{ route('donor.donations.food.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    
                    <div class="card-body">
                        <!-- Food Items Section -->
                        <div class="mb-5">
                            <div class="d-flex align-items-center mb-4">
                                <div class="icon-circle bg-primary-subtle text-primary me-3">
                                    <i class="fas fa-utensils"></i>
                                </div>
                                <h3 class="h5 mb-0 fw-bold text-dark">Food Items</h3>
                            </div>
                            
                            <div id="food-items-container">
                                <!-- Food Item 1 -->
                                <div class="food-item card mb-4 border">
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <!-- Food Type -->
                                            <div class="col-md-6 col-lg-4">
                                                <label class="form-label fw-medium">Type of Food <span class="text-danger">*</span></label>
                                                <select name="food_items[0][type]" required class="form-select">
                                                    <option value="">Select food type</option>
                                                    <option value="canned">Canned Goods</option>
                                                    <option value="packaged">Packaged Food</option>
                                                    <option value="fresh">Fresh Produce</option>
                                                    <option value="beverages">Beverages</option>
                                                    <option value="baby_food">Baby Food/Formula</option>
                                                    <option value="other">Other</option>
                                                </select>
                                                <div class="invalid-feedback">Please select a food type.</div>
                                            </div>
                                            
                                            <!-- Quantity -->
                                            <div class="col-md-6 col-lg-4">
                                                <label class="form-label fw-medium">Quantity <span class="text-danger">*</span></label>
                                                <input type="number" name="food_items[0][quantity]" min="1" required class="form-control">
                                                <div class="invalid-feedback">Please enter a valid quantity.</div>
                                            </div>
                                            
                                            <!-- Unit -->
                                            <div class="col-md-6 col-lg-4">
                                                <label class="form-label fw-medium">Unit <span class="text-danger">*</span></label>
                                                <select name="food_items[0][unit]" required class="form-select">
                                                    <option value="pieces">Pieces</option>
                                                    <option value="kg">Kilograms</option>
                                                    <option value="g">Grams</option>
                                                    <option value="l">Liters</option>
                                                    <option value="ml">Milliliters</option>
                                                    <option value="boxes">Boxes</option>
                                                    <option value="packs">Packs</option>
                                                </select>
                                                <div class="invalid-feedback">Please select a unit.</div>
                                            </div>
                                            
                                            <!-- Description -->
                                            <div class="col-12">
                                                <label class="form-label fw-medium">Description (e.g., brand, flavor, size)</label>
                                                <input type="text" name="food_items[0][description]" class="form-control" placeholder="E.g., Brand X Rice, 5kg bag">
                                            </div>
                                            
                                            <!-- Expiry Date -->
                                            <div class="col-md-6">
                                                <label class="form-label fw-medium">Expiry Date <span class="text-danger">*</span></label>
                                                <input type="date" name="food_items[0][expiry_date]" required min="{{ now()->format('Y-m-d') }}" class="form-control">
                                                <div class="invalid-feedback">Please enter a valid expiry date.</div>
                                            </div>
                                            
                                            <!-- Storage Requirements -->
                                            <div class="col-md-6">
                                                <label class="form-label fw-medium">Storage Requirements</label>
                                                <div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="food_items[0][storage]" id="storage-temp-0" value="room_temp" checked>
                                                        <label class="form-check-label" for="storage-temp-0">Room Temperature</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="food_items[0][storage]" id="storage-ref-0" value="refrigerated">
                                                        <label class="form-check-label" for="storage-ref-0">Refrigerated</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="food_items[0][storage]" id="storage-frozen-0" value="frozen">
                                                        <label class="form-check-label" for="storage-frozen-0">Frozen</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-3 text-end">
                                            <button type="button" class="btn btn-sm btn-outline-danger remove-food-item">
                                                <i class="fas fa-trash me-1"></i> Remove Item
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-2">
                                <button type="button" id="add-food-item" class="btn btn-outline-primary">
                                    <i class="fas fa-plus me-1"></i> Add Another Food Item
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
                                        <option value="food_drive">Food Drive</option>
                                        <option value="restaurant">Restaurant/Catering</option>
                                        <option value="grocery">Grocery Store</option>
                                        <option value="other">Other</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a donation type.</div>
                                </div>
                                
                                <!-- Preferred Delivery/Pickup Date -->
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
                            </div>
                        </div>
                        
                        <!-- Terms and Conditions -->
                        <div class="border rounded p-4 mb-4 bg-light">
                            <div class="form-check mb-3">
                                <input id="terms" name="terms" type="checkbox" required class="form-check-input">
                                <label for="terms" class="form-check-label fw-medium">I agree to the terms and conditions <span class="text-danger">*</span></label>
                                <div class="invalid-feedback">You must agree to the terms and conditions.</div>
                            </div>
                            <p class="text-muted mb-0">I confirm that all food items are unopened, unexpired, and properly stored. I understand that perishable items may be refused if they don't meet safety standards.</p>
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
    // Add new food item
    let foodItemCount = 1;
    document.getElementById('add-food-item').addEventListener('click', function() {
        const container = document.getElementById('food-items-container');
        const newItem = document.querySelector('.food-item').cloneNode(true);
        
        // Update the index for the new item
        const newIndex = foodItemCount++;
        newItem.innerHTML = newItem.innerHTML.replace(/\[0\]/g, `[${newIndex}]`);
        
        // Clear the values
        const inputs = newItem.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            if (input.type === 'radio' || input.type === 'checkbox') {
                input.checked = false;
            } else if (input.type !== 'button') {
                input.value = '';
            }
        });
        
        // Make sure the first radio is checked by default for storage
        newItem.querySelector('input[type="radio"]').checked = true;
        
        // Add remove functionality
        const removeButton = newItem.querySelector('.remove-food-item');
        removeButton.addEventListener('click', function() {
            newItem.remove();
        });
        
        container.appendChild(newItem);
    });
    
    // Remove food item
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-food-item')) {
            const foodItems = document.querySelectorAll('.food-item');
            if (foodItems.length > 1) {
                e.target.closest('.food-item').remove();
            } else {
                alert('At least one food item is required.');
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
        
        // Set minimum date for expiry dates
        const expiryInputs = document.querySelectorAll('input[name$="[expiry_date]"]');
        expiryInputs.forEach(input => {
            input.min = today.toISOString().split('T')[0];
        });
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