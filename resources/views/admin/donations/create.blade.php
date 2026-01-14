@extends('layouts.admin')

@section('title', 'Add New Donation')

@push('styles')
<style>
    .form-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem;
        background: #fff;
        border-radius: 0.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .donation-type-selector .btn-check:checked + .btn-outline-primary {
        background-color: var(--primary);
        color: #fff;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add New Donation</h1>
        <a href="{{ route('admin.donations.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Donations
        </a>
    </div>

    <div class="form-container">
        <form action="{{ route('admin.donations.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="mb-3">Donor Information</h5>
                    <div class="mb-3">
                        <label for="donor_id" class="form-label">Select Donor</label>
                        <select class="form-select" id="donor_id" name="donor_id" required>
                            <option value="" disabled selected>Select a donor</option>
                            @foreach($donors as $donor)
                                <option value="{{ $donor->id }}">{{ $donor->name }} ({{ $donor->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Or add as guest donor</label>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="guestDonorToggle">
                            <label class="form-check-label" for="guestDonorToggle">This is a guest donation</label>
                        </div>
                        
                        <div id="guestDonorFields" style="display: none;">
                            <div class="mb-3">
                                <label for="guest_name" class="form-label">Guest Name</label>
                                <input type="text" class="form-control" id="guest_name" name="guest_name">
                            </div>
                            <div class="mb-3">
                                <label for="guest_email" class="form-label">Email (optional)</label>
                                <input type="email" class="form-control" id="guest_email" name="guest_email">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <h5 class="mb-3">Donation Details</h5>
                    
                    <div class="mb-3 donation-type-selector">
                        <label class="form-label">Donation Type</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach(['cash' => 'Cash', 'food' => 'Food', 'clothing' => 'Clothing', 'medical' => 'Medical', 'other' => 'Other'] as $value => $label)
                                <input type="radio" class="btn-check" name="type" id="type_{{ $value }}" value="{{ $value }}" {{ $loop->first ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="type_{{ $value }}">
                                    <i class="fas fa-{{ 
                                        $value === 'cash' ? 'money-bill-wave' : 
                                        ($value === 'food' ? 'utensils' : 
                                        ($value === 'clothing' ? 'tshirt' : 
                                        ($value === 'medical' ? 'pills' : 'gift'))) 
                                    }} me-2"></i>
                                    {{ $label }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    
                    <div id="cashFields">
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount (₱)</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="{{ old('amount') }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select class="form-select" id="payment_method" name="payment_method">
                                <option value="cash">Cash</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="gcash">GCash</option>
                                <option value="paypal">PayPal</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    
                    <div id="nonCashFields" style="display: none;">
                        <div class="mb-3">
                            <label for="items_count" class="form-label">Number of Items</label>
                            <input type="number" class="form-control" id="items_count" name="items_count" min="1" value="1">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Brief description of the items"></textarea>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes (Optional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Any additional notes about this donation"></textarea>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.donations.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i> Save Donation
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeCash = document.getElementById('type_cash');
    const typeOther = document.querySelectorAll('input[name="type"]:not(#type_cash)');
    const cashFields = document.getElementById('cashFields');
    const nonCashFields = document.getElementById('nonCashFields');
    
    // Toggle guest donor fields
    const guestDonorToggle = document.getElementById('guestDonorToggle');
    const guestDonorFields = document.getElementById('guestDonorFields');
    const donorSelect = document.getElementById('donor_id');
    
    guestDonorToggle.addEventListener('change', function() {
        if (this.checked) {
            guestDonorFields.style.display = 'block';
            donorSelect.disabled = true;
            donorSelect.required = false;
            document.getElementById('guest_name').required = true;
        } else {
            guestDonorFields.style.display = 'none';
            donorSelect.disabled = false;
            donorSelect.required = true;
            document.getElementById('guest_name').required = false;
        }
    });
    
    // Toggle between cash and non-cash fields
    function toggleDonationType() {
        if (typeCash.checked) {
            cashFields.style.display = 'block';
            nonCashFields.style.display = 'none';
            document.getElementById('amount').required = true;
            document.getElementById('items_count').required = false;
        } else {
            cashFields.style.display = 'none';
            nonCashFields.style.display = 'block';
            document.getElementById('amount').required = false;
            document.getElementById('items_count').required = true;
        }
    }
    
    // Initial setup
    toggleDonationType();
    
    // Add event listeners to all type radio buttons
    document.querySelectorAll('input[name="type"]').forEach(radio => {
        radio.addEventListener('change', toggleDonationType);
    });
    
    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Reset error states
        document.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
        
        // Validate donor selection or guest info
        if (!guestDonorToggle.checked && !donorSelect.value) {
            donorSelect.classList.add('is-invalid');
            isValid = false;
        }
        
        if (guestDonorToggle.checked && !document.getElementById('guest_name').value) {
            document.getElementById('guest_name').classList.add('is-invalid');
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
            // Scroll to first error
            const firstError = document.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });
});
</script>
@endpush
