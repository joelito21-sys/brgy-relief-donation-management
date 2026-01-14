@extends('donor.layouts.dashboard')

@section('title', 'Cash Donation - Barangay Cubacub Relief and Donation Management Program')

@section('header', 'Cash Donation')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Cash Donation</h4>
                    <p class="mb-0">Your generous donation will help us continue our mission. Thank you for your support!</p>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5 class="mb-3">Choose Payment Method</h5>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('donor.donations.cash.payment', ['method' => 'gcash']) }}" 
                                   class="btn btn-outline-primary w-100 py-3">
                                    <i class="fas fa-wallet text-primary me-2"></i>GCash
                                </a>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('donor.donations.cash.payment', ['method' => 'paymaya']) }}" 
                                   class="btn btn-outline-secondary w-100 py-3">
                                    <i class="fas fa-credit-card text-purple me-2"></i>PayMaya
                                </a>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('donor.donations.cash.payment', ['method' => 'bank']) }}" 
                                   class="btn btn-outline-success w-100 py-3">
                                    <i class="fas fa-building-columns text-success me-2"></i>Bank Transfer
                                </a>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('donor.donations.cash.payment', ['method' => 'walkin']) }}" 
                                   class="btn btn-outline-warning w-100 py-3">
                                    <i class="fas fa-person-walking text-warning me-2"></i>Walk-in
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('donor.donations.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection