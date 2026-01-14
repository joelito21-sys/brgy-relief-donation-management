@extends('admin.layouts.app')

@section('title', 'Edit Relief Request')

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
        <div>
            <h1 class="h3 mb-0">Edit Relief Request</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.relief-requests.index') }}">Relief Requests</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.relief-requests.show', $reliefRequest) }}">#{{ $reliefRequest->request_number }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.relief-requests.show', $reliefRequest) }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i> Back to Request
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.relief-requests.update', $reliefRequest) }}" method="POST" id="reliefRequestForm">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <!-- Resident Selection -->
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Resident <span class="text-danger">*</span></label>
                            <select class="form-select select2 @error('user_id') is-invalid @enderror" 
                                    id="user_id" 
                                    name="user_id" 
                                    required
                                    {{ $reliefRequest->isPending() ? '' : 'disabled' }}>
                                @foreach($residents as $resident)
                                    <option value="{{ $resident->id }}" 
                                            {{ old('user_id', $reliefRequest->user_id) == $resident->id ? 'selected' : '' }}>
                                        {{ $resident->name }} ({{ $resident->contact_number }})
                                    </option>
                                @endforeach
                            </select>
                            @if(!$reliefRequest->isPending())
                                <input type="hidden" name="user_id" value="{{ $reliefRequest->user_id }}">
                                <div class="form-text text-muted">
                                    <i class="fas fa-info-circle"></i> Cannot change resident after request is processed.
                                </div>
                            @endif
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
                                       {{ old('delivery_method', $reliefRequest->delivery_method) == 'pickup' ? 'checked' : '' }}
                                       {{ $reliefRequest->isPending() ? '' : 'disabled' }}>
                                <label class="form-check-label" for="delivery_pickup">
                                    Pickup
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="delivery_method" 
                                       id="delivery_delivery" value="delivery"
                                       {{ old('delivery_method', $reliefRequest->delivery_method) == 'delivery' ? 'checked' : '' }}
                                       {{ $reliefRequest->isPending() ? '' : 'disabled' }}>
                                <label class="form-check-label" for="delivery_delivery">
                                    Delivery
                                </label>
                            </div>
                            @if(!$reliefRequest->isPending())
                                <div class="form-text text-muted">
                                    <i class="fas fa-info-circle"></i> Cannot change delivery method after request is processed.
                                </div>
                                <input type="hidden" name="delivery_method" value="{{ $reliefRequest->delivery_method }}">
                            @endif
                            @error('delivery_method')
                                <div class="text-danger" style="font-size: 0.875em;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Dynamic Fields based on Delivery Method -->
                        <div id="pickupFields" style="display: {{ old('delivery_method', $reliefRequest->delivery_method) == 'pickup' ? 'block' : 'none' }};">
                            <div class="mb-3">
                                <label for="pickup_location" class="form-label">Pickup Location <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('pickup_location') is-invalid @enderror" 
                                       id="pickup_location" name="pickup_location" 
                                       value="{{ old('pickup_location', $reliefRequest->pickup_location) }}">
                                @error('pickup_location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="scheduled_pickup_date" class="form-label">Scheduled Pickup Date</label>
                                <input type="datetime-local" class="form-control @error('scheduled_pickup_date') is-invalid @enderror" 
                                       id="scheduled_pickup_date" name="scheduled_pickup_date"
                                       value="{{ old('scheduled_pickup_date', $reliefRequest->scheduled_pickup_date ? $reliefRequest->scheduled_pickup_date->format('Y-m-d\TH:i') : '') }}">
                                @error('scheduled_pickup_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div id="deliveryFields" style="display: {{ old('delivery_method', $reliefRequest->delivery_method) == 'delivery' ? 'block' : 'none' }};">
                            <div class="mb-3">
                                <label for="delivery_address" class="form-label">Delivery Address <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('delivery_address') is-invalid @enderror" 
                                          id="delivery_address" name="delivery_address" 
                                          rows="3">{{ old('delivery_address', $reliefRequest->delivery_address) }}</textarea>
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
                                   min="1" max="20" value="{{ old('family_members', $reliefRequest->family_members) }}">
                            @error('family_members')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Reason -->
                        <div class="mb-3">
                            <label for="reason" class="form-label">Reason for Request</label>
                            <textarea class="form-control @error('reason') is-invalid @enderror" 
                                      id="reason" name="reason" 
                                      rows="3">{{ old('reason', $reliefRequest->reason) }}</textarea>
                            @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Select Relief Items <span class="text-danger">*</span></label>
                            <select class="form-select select2 @error('items') is-invalid @enderror" 
                                    id="item_selector" multiple="multiple"
                                    {{ $reliefRequest->isPending() ? '' : 'disabled' }}>
                                @foreach($reliefItems as $item)
                                    @php
                                        $selected = false;
                                        $selectedQty = 0;
                                        $selectedNotes = '';
                                        
                                        if (old('items')) {
                                            $selected = isset(old('items')[$item->id]);
                                            $selectedQty = old('items')[$item->id]['quantity'] ?? 0;
                                            $selectedNotes = old('items')[$item->id]['notes'] ?? '';
                                        } else {
                                            $pivot = $reliefRequest->items->find($item->id)->pivot ?? null;
                                            if ($pivot) {
                                                $selected = true;
                                                $selectedQty = $pivot->quantity;
                                                $selectedNotes = $pivot->notes;
                                            }
                                        }
                                        
                                        $availableQty = $item->quantity_available + ($selected ? $selectedQty : 0);
                                    @endphp
                                    
                                    <option value="{{ $item->id }}" 
                                            data-name="{{ $item->name }}" 
                                            data-type="{{ $item->type }}"
                                            data-unit="{{ $item->unit }}"
                                            data-available="{{ $availableQty }}"
                                            data-image="{{ $item->image_path ? asset('storage/' . $item->image_path) : asset('images/default-item.jpg') }}"
                                            data-selected="{{ $selected ? 'true' : 'false' }}"
                                            data-quantity="{{ $selectedQty }}"
                                            data-notes="{{ $selectedNotes }}"
                                            {{ $selected ? 'selected' : '' }}>
                                        {{ $item->name }} ({{ $availableQty }} {{ $item->unit }} available)
                                    </option>
                                @endforeach
                            </select>
                            @if(!$reliefRequest->isPending())
                                <div class="form-text text-muted">
                                    <i class="fas fa-info-circle"></i> Cannot change items after request is processed.
                                </div>
                            @endif
                            <div class="form-text">Search and select items to add to this request</div>
                            @error('items')
                                <div class="text-danger" style="font-size: 0.875em;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Selected Items -->
                        <div class="mb-3">
                            <label class="form-label">Selected Items</label>
                            <div id="selectedItems" class="row g-3">
                                @php
                                    $hasItems = false;
                                    if (old('items')) {
                                        $hasItems = count(old('items')) > 0;
                                    } else {
                                        $hasItems = $reliefRequest->items->count() > 0;
                                    }
                                @endphp
                                
                                @if(!$hasItems)
                                    <div class="col-12" id="noItemsMessage">
                                        <div class="alert alert-info mb-0">
                                            <i class="fas fa-info-circle me-2"></i>
                                            No items selected. Please select items from the dropdown above.
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Hidden fields for form submission -->
                        <div id="itemFields">
                            @if(old('items'))
                                @foreach(old('items') as $itemId => $itemData)
                                    <input type="hidden" name="items[{{ $itemId }}][quantity]" value="{{ $itemData['quantity'] }}">
                                    <input type="hidden" name="items[{{ $itemId }}][notes]" value="{{ $itemData['notes'] ?? '' }}">
                                @endforeach
                            @else
                                @foreach($reliefRequest->items as $item)
                                    <input type="hidden" name="items[{{ $item->id }}][quantity]" value="{{ $item->pivot->quantity }}">
                                    <input type="hidden" name="items[{{ $item->id }}][notes]" value="{{ $item->pivot->notes ?? '' }}">
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <a href="{{ route('admin.relief-requests.show', $reliefRequest) }}" class="btn btn-outline-secondary me-md-2">
                        <i class="fas fa-times me-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Update Request
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
                                   min="1" value="1" style="width: 80px;"
                                   {{ $reliefRequest->isPending() ? '' : 'disabled' }}>
                            <span class="ms-2 item-unit"></span>
                            <div class="ms-auto text-end">
                                <span class="badge bg-success item-available"></span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <label class="small text-muted mb-1">Notes:</label>
                            <input type="text" class="form-control form-control-sm item-notes" 
                                   placeholder="Add notes (optional)" {{ $reliefRequest->isPending() ? '' : 'disabled' }}>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-center justify-content-center">
                    @if($reliefRequest->isPending())
                        <button type="button" class="btn btn-sm btn-outline-danger remove-item">
                            <i class="fas fa-times"></i>
                        </button>
                    @endif
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

        // Handle item selection and rendering
        const itemTemplate = document.getElementById('itemTemplate');
        const selectedItemsContainer = document.getElementById('selectedItems');
        const noItemsMessage = document.getElementById('noItemsMessage');
        const itemFieldsContainer = document.getElementById('itemFields');
        const selectedItems = new Set();
        
        // Add item to the list
        function addItem(itemId, itemName, itemType, itemUnit, availableQty, imageUrl, quantity = 1, notes = '') {
            if (selectedItems.has(itemId)) {
                // Update quantity if item already exists
                const existingItem = document.querySelector(`[data-item-id="${itemId}"]`);
                if (existingItem) {
                    const quantityInput = existingItem.querySelector('.item-quantity');
                    const currentQty = parseInt(quantityInput.value) || 0;
                    const newQty = currentQty + (quantity || 1);
                    quantityInput.value = newQty > availableQty ? availableQty : newQty;
                    updateItemInput(itemId, quantityInput.value, existingItem.querySelector('.item-notes').value);
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
            clone.querySelector('.item-quantity').value = quantity || 1;
            clone.querySelector('.item-notes').value = notes || '';
            clone.querySelector('.item-image').src = imageUrl;
            
            // Handle quantity change
            clone.querySelector('.item-quantity').addEventListener('change', function() {
                const newQty = parseInt(this.value) || 0;
                const maxQty = parseInt(this.getAttribute('max')) || 0;
                
                if (newQty < 1) {
                    this.value = 1;
                    updateItemInput(itemId, 1, this.closest('.item-card').querySelector('.item-notes').value);
                } else if (newQty > maxQty) {
                    this.value = maxQty;
                    updateItemInput(itemId, maxQty, this.closest('.item-card').querySelector('.item-notes').value);
                } else {
                    updateItemInput(itemId, newQty, this.closest('.item-card').querySelector('.item-notes').value);
                }
            });
            
            // Handle notes change
            clone.querySelector('.item-notes').addEventListener('change', function() {
                const itemCard = this.closest('.item-card');
                const itemId = itemCard.getAttribute('data-item-id');
                const quantity = itemCard.querySelector('.item-quantity').value;
                updateItemInput(itemId, quantity, this.value);
            });
            
            // Handle remove button
            const removeBtn = clone.querySelector('.remove-item');
            if (removeBtn) {
                removeBtn.addEventListener('click', function() {
                    itemCard.remove();
                    selectedItems.delete(itemId);
                    updateItemInput(itemId, 0, ''); // Remove from form
                    
                    // Show no items message if no items left
                    if (selectedItems.size === 0 && noItemsMessage) {
                        noItemsMessage.style.display = 'block';
                    }
                    
                    // Re-enable the item in the dropdown
                    $(`#item_selector option[value="${itemId}"]`).prop('disabled', false);
                    $('#item_selector').trigger('change');
                });
            }
            
            // Add to DOM
            if (noItemsMessage) {
                noItemsMessage.style.display = 'none';
            }
            selectedItemsContainer.prepend(clone);
            
            // Add hidden input for form submission
            updateItemInput(itemId, quantity || 1, notes || '');
        }
        
        // Update or remove hidden input
        function updateItemInput(itemId, quantity, notes = '') {
            let quantityInput = document.querySelector(`input[name="items[${itemId}][quantity]"]`);
            let notesInput = document.querySelector(`input[name="items[${itemId}][notes]"]`);
            
            if (quantity > 0) {
                if (!quantityInput) {
                    // Create quantity input
                    quantityInput = document.createElement('input');
                    quantityInput.type = 'hidden';
                    quantityInput.name = `items[${itemId}][quantity]`;
                    itemFieldsContainer.appendChild(quantityInput);
                    
                    // Create notes input
                    notesInput = document.createElement('input');
                    notesInput.type = 'hidden';
                    notesInput.name = `items[${itemId}][notes]`;
                    itemFieldsContainer.appendChild(notesInput);
                }
                
                quantityInput.value = quantity;
                notesInput.value = notes || '';
            } else if (quantityInput) {
                // Remove both quantity and notes inputs
                if (notesInput) notesInput.remove();
                quantityInput.remove();
            }
        }
        
        // Initialize with existing items
        function initializeItems() {
            // Clear any existing items
            selectedItems.clear();
            document.querySelectorAll('.item-card-container').forEach(el => el.remove());
            
            // Get items from the form or from the model
            let items = [];
            
            @if(old('items'))
                @foreach($reliefItems as $item)
                    @if(isset(old('items')[$item->id]))
                        items.push({
                            id: '{{ $item->id }}',
                            name: '{{ $item->name }}',
                            type: '{{ $item->type }}',
                            unit: '{{ $item->unit }}',
                            available: {{ $item->quantity_available + (int)old('items')[$item->id]['quantity'] }},
                            quantity: {{ (int)old('items')[$item->id]['quantity'] }},
                            notes: '{{ old('items')[$item->id]['notes'] ?? '' }}',
                            image: '{{ $item->image_path ? asset('storage/' . $item->image_path) : asset('images/default-item.jpg') }}'
                        });
                    @endif
                @endforeach
            @else
                @foreach($reliefRequest->items as $item)
                    items.push({
                        id: '{{ $item->id }}',
                        name: '{{ $item->name }}',
                        type: '{{ $item->type }}',
                        unit: '{{ $item->unit }}',
                        available: {{ $item->quantity_available + $item->pivot->quantity }},
                        quantity: {{ $item->pivot->quantity }},
                        notes: '{{ $item->pivot->notes ?? '' }}',
                        image: '{{ $item->image_path ? asset('storage/' . $item->image_path) : asset('images/default-item.jpg') }}'
                    });
                @endforeach
            @endif
            
            // Add items to the UI
            items.forEach(item => {
                addItem(
                    item.id,
                    item.name,
                    item.type,
                    item.unit,
                    item.available,
                    item.image,
                    item.quantity,
                    item.notes
                );
                
                // Disable the selected item in the dropdown
                $(`#item_selector option[value="${item.id}"]`).prop('disabled', true);
            });
            
            // Update the select2 dropdown
            $('#item_selector').trigger('change');
            
            // Show/hide no items message
            if (noItemsMessage) {
                noItemsMessage.style.display = items.length > 0 ? 'none' : 'block';
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
            
            // Disable the selected option to prevent duplicate selection
            $(`#item_selector option[value="${itemId}"]`).prop('disabled', true);
            
            // Clear selection
            $(this).val(null).trigger('change');
        });
        
        // Initialize the form
        initializeItems();
        
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
    });
</script>
@endpush
