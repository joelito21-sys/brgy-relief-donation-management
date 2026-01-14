@extends('admin.layouts.app')

@section('title', 'Create Relief Request')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #ced4da;
        padding: 0.35rem 0.75rem;
        min-height: 38px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #e9ecef;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        padding: 0 0.5rem;
    }
    .item-card {
        transition: all 0.3s ease;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        overflow: hidden;
    }
    .item-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }
    .item-card .card-body {
        padding: 1rem;
    }
    .item-card .item-image {
        height: 120px;
        object-fit: cover;
    }
    .item-quantity {
        width: 70px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Create Relief Request</h1>
        <div>
            <a href="{{ route('admin.relief-requests.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to List
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.relief-requests.store') }}" method="POST" id="reliefRequestForm">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <!-- Resident Selection -->
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Resident <span class="text-danger">*</span></label>
                            <select class="form-select select2 @error('user_id') is-invalid @enderror" 
                                    id="user_id" 
                                    name="user_id" 
                                    required>
                                <option value="">Select Resident</option>
                                @foreach($residents as $resident)
                                    <option value="{{ $resident->id }}" 
                                            {{ old('user_id') == $resident->id ? 'selected' : '' }}>
                                        {{ $resident->name }} ({{ $resident->contact_number }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Delivery Method -->
                        <div class="mb-3">
                            <label class="form-label">Delivery Method <span class="text-danger">*</span></label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="delivery_method" 
                                       id="delivery_pickup" value="pickup" 
                                       {{ old('delivery_method', 'pickup') == 'pickup' ? 'checked' : '' }}>
                                <label class="form-check-label" for="delivery_pickup">
                                    Pickup
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="delivery_method" 
                                       id="delivery_delivery" value="delivery"
                                       {{ old('delivery_method') == 'delivery' ? 'checked' : '' }}>
                                <label class="form-check-label" for="delivery_delivery">
                                    Delivery
                                </label>
                            </div>
                            @error('delivery_method')
                                <div class="text-danger" style="font-size: 0.875em;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Dynamic Fields based on Delivery Method -->
                        <div id="pickupFields" style="display: {{ old('delivery_method', 'pickup') == 'pickup' ? 'block' : 'none' }};">
                            <div class="mb-3">
                                <label for="pickup_location" class="form-label">Pickup Location <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('pickup_location') is-invalid @enderror" 
                                       id="pickup_location" name="pickup_location" 
                                       value="{{ old('pickup_location', 'Main Relief Center - 123 Main St, City') }}">
                                @error('pickup_location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="scheduled_pickup_date" class="form-label">Scheduled Pickup Date</label>
                                <input type="datetime-local" class="form-control @error('scheduled_pickup_date') is-invalid @enderror" 
                                       id="scheduled_pickup_date" name="scheduled_pickup_date"
                                       value="{{ old('scheduled_pickup_date') }}">
                                @error('scheduled_pickup_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div id="deliveryFields" style="display: {{ old('delivery_method') == 'delivery' ? 'block' : 'none' }};">
                            <div class="mb-3">
                                <label for="delivery_address" class="form-label">Delivery Address <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('delivery_address') is-invalid @enderror" 
                                          id="delivery_address" name="delivery_address" 
                                          rows="3">{{ old('delivery_address') }}</textarea>
                                @error('delivery_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Family Members -->
                        <div class="mb-3">
                            <label for="family_members" class="form-label">Family Members <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('family_members') is-invalid @enderror" 
                                   id="family_members" name="family_members" 
                                   min="1" max="20" value="{{ old('family_members', 1) }}">
                            @error('family_members')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Reason -->
                        <div class="mb-3">
                            <label for="reason" class="form-label">Reason for Request</label>
                            <textarea class="form-control @error('reason') is-invalid @enderror" 
                                      id="reason" name="reason" 
                                      rows="3">{{ old('reason') }}</textarea>
                            @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Select Relief Items <span class="text-danger">*</span></label>
                            <select class="form-select select2 @error('items') is-invalid @enderror" 
                                    id="item_selector" multiple="multiple">
                                @foreach($reliefItems as $item)
                                    <option value="{{ $item->id }}" 
                                            data-name="{{ $item->name }}" 
                                            data-type="{{ $item->type }}"
                                            data-unit="{{ $item->unit }}"
                                            data-available="{{ $item->quantity_available }}"
                                            data-image="{{ $item->image_path ? asset('storage/' . $item->image_path) : asset('images/default-item.jpg') }}">
                                        {{ $item->name }} ({{ $item->quantity_available }} {{ $item->unit }} available)
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Search and select items to add to this request</div>
                            @error('items')
                                <div class="text-danger" style="font-size: 0.875em;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Selected Items -->
                        <div class="mb-3">
                            <label class="form-label">Selected Items</label>
                            <div id="selectedItems" class="row g-3">
                                <!-- Items will be added here dynamically -->
                                <div class="col-12" id="noItemsMessage">
                                    <div class="alert alert-info mb-0">
                                        <i class="fas fa-info-circle me-2"></i>
                                        No items selected. Please select items from the dropdown above.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden fields for form submission -->
                        <div id="itemFields">
                            <!-- Will be populated by JavaScript -->
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="reset" class="btn btn-outline-secondary me-md-2">
                        <i class="fas fa-undo me-1"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Item Template (Hidden) -->
<template id="itemTemplate">
    <div class="col-12 item-card-container">
        <div class="card item-card mb-3">
            <div class="row g-0">
                <div class="col-md-3">
                    <img src="" class="img-fluid rounded-start item-image w-100 h-100" alt="Item Image">
                </div>
                <div class="col-md-7">
                    <div class="card-body">
                        <h5 class="card-title mb-1 item-name"></h5>
                        <p class="card-text small text-muted mb-2 item-type"></p>
                        <div class="d-flex align-items-center">
                            <label class="me-2 mb-0">Quantity:</label>
                            <input type="number" class="form-control form-control-sm item-quantity" 
                                   min="1" value="1" style="width: 80px;">
                            <span class="ms-2 item-unit"></span>
                            <div class="ms-auto text-end">
                                <span class="badge bg-success item-available"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-center justify-content-center">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-item">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2({
            placeholder: 'Search and select items',
            allowClear: true,
            width: '100%',
            closeOnSelect: false
        });

        // Toggle delivery method fields
        $('input[name="delivery_method"]').change(function() {
            if ($(this).val() === 'pickup') {
                $('#pickupFields').show();
                $('#deliveryFields').hide();
            } else {
                $('#pickupFields').hide();
                $('#deliveryFields').show();
            }
        });

        // Handle item selection
        const itemTemplate = document.getElementById('itemTemplate');
        const selectedItemsContainer = document.getElementById('selectedItems');
        const noItemsMessage = document.getElementById('noItemsMessage');
        const itemFieldsContainer = document.getElementById('itemFields');
        const selectedItems = new Set();

        // Add item to the list
        function addItem(itemId, itemName, itemType, itemUnit, availableQty, imageUrl) {
            if (selectedItems.has(itemId)) {
                // Update quantity if item already exists
                const existingItem = document.querySelector(`[data-item-id="${itemId}"]`);
                if (existingItem) {
                    const quantityInput = existingItem.querySelector('.item-quantity');
                    const currentQty = parseInt(quantityInput.value) || 0;
                    quantityInput.value = currentQty + 1;
                    updateItemInput(itemId, currentQty + 1);
                }
                return;
            }

            selectedItems.add(itemId);
            
            const clone = itemTemplate.content.cloneNode(true);
            const itemCard = clone.querySelector('.item-card');
            itemCard.setAttribute('data-item-id', itemId);
            
            // Set item details
            clone.querySelector('.item-name').textContent = itemName;
            clone.querySelector('.item-type').textContent = itemType.charAt(0).toUpperCase() + itemType.slice(1);
            clone.querySelector('.item-unit').textContent = itemUnit;
            clone.querySelector('.item-available').textContent = `${availableQty} available`;
            clone.querySelector('.item-quantity').setAttribute('max', availableQty);
            clone.querySelector('.item-image').src = imageUrl;
            
            // Handle quantity change
            clone.querySelector('.item-quantity').addEventListener('change', function() {
                const newQty = parseInt(this.value) || 0;
                const maxQty = parseInt(this.getAttribute('max')) || 0;
                
                if (newQty < 1) {
                    this.value = 1;
                    updateItemInput(itemId, 1);
                } else if (newQty > maxQty) {
                    this.value = maxQty;
                    updateItemInput(itemId, maxQty);
                } else {
                    updateItemInput(itemId, newQty);
                }
            });
            
            // Handle remove button
            clone.querySelector('.remove-item').addEventListener('click', function() {
                itemCard.remove();
                selectedItems.delete(itemId);
                updateItemInput(itemId, 0); // Remove from form
                
                if (selectedItems.size === 0) {
                    noItemsMessage.style.display = 'block';
                }
            });
            
            // Add to DOM
            if (noItemsMessage) {
                noItemsMessage.style.display = 'none';
            }
            selectedItemsContainer.prepend(clone);
            
            // Add hidden input for form submission
            updateItemInput(itemId, 1);
        }
        
        // Update or remove hidden input
        function updateItemInput(itemId, quantity) {
            let input = document.querySelector(`input[name="items[${itemId}][quantity]"]`);
            
            if (quantity > 0) {
                if (!input) {
                    input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = `items[${itemId}][quantity]`;
                    input.value = quantity;
                    itemFieldsContainer.appendChild(input);
                    
                    // Add notes input as well
                    const notesInput = document.createElement('input');
                    notesInput.type = 'hidden';
                    notesInput.name = `items[${itemId}][notes]`;
                    notesInput.value = ''; // Default empty notes
                    itemFieldsContainer.appendChild(notesInput);
                } else {
                    input.value = quantity;
                }
            } else if (input) {
                // Remove both quantity and notes inputs
                const notesInput = document.querySelector(`input[name="items[${itemId}][notes]"]`);
                if (notesInput) notesInput.remove();
                input.remove();
            }
        }
        
        // Handle item selection from dropdown
        $('#item_selector').on('select2:select', function(e) {
            const option = e.params.data.element;
            const itemId = option.value;
            const itemName = option.dataset.name;
            const itemType = option.dataset.type;
            const itemUnit = option.dataset.unit;
            const availableQty = parseInt(option.dataset.available) || 0;
            const imageUrl = option.dataset.image || '{{ asset("images/default-item.jpg") }}';
            
            addItem(itemId, itemName, itemType, itemUnit, availableQty, imageUrl);
            
            // Clear selection
            $(this).val(null).trigger('change');
        });
        
        // Form validation
        $('#reliefRequestForm').on('submit', function(e) {
            if (selectedItems.size === 0) {
                e.preventDefault();
                alert('Please select at least one item for the request.');
                return false;
            }
            
            // Additional validation can be added here
            return true;
        });
        
        // Initialize with any previously selected items (in case of validation errors)
        @if(old('items'))
            @foreach($reliefItems as $item)
                @if(isset(old('items')[$item->id]))
                    addItem(
                        '{{ $item->id }}', 
                        '{{ $item->name }}', 
                        '{{ $item->type }}', 
                        '{{ $item->unit }}', 
                        {{ $item->quantity_available }}, 
                        '{{ $item->image_path ? asset('storage/' . $item->image_path) : asset('images/default-item.jpg') }}'
                    );
                    
                    // Set the quantity from old input
                    const quantity = {{ old('items')[$item->id]['quantity'] ?? 1 }};
                    const quantityInput = document.querySelector(`[data-item-id="{{ $item->id }}"] .item-quantity`);
                    if (quantityInput) {
                        quantityInput.value = quantity;
                        updateItemInput('{{ $item->id }}', quantity);
                    }
                @endif
            @endforeach
        @endif
    });
</script>
@endpush
