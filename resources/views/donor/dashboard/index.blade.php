@extends('donor.layouts.dashboard')

@section('header', 'Donor Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </div>
                <div class="card-body text-center py-5">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <h3 class="mb-4">Welcome, {{ Auth::guard('donor')->user()->name }}! 👋</h3>
                    <p class="text-muted mb-4">What would you like to do today?</p>
                    
                    <div class="row g-3">
                        <div class="col-6 col-md-4">
                            <a href="{{ route('donor.activities') }}" class="text-decoration-none">
                                <div class="p-3 border rounded hover-shadow">
                                    <i class="fas fa-tasks fa-2x text-primary mb-2"></i>
                                    <div>Activities</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4">
                            <a href="{{ route('donor.history') }}" class="text-decoration-none">
                                <div class="p-3 border rounded hover-shadow">
                                    <i class="fas fa-hand-holding-heart fa-2x text-primary mb-2"></i>
                                    <div>My Donations</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4">
                            <a href="{{ route('donor.profile') }}" class="text-decoration-none">
                                <div class="p-3 border rounded hover-shadow">
                                    <i class="fas fa-user fa-2x text-primary mb-2"></i>
                                    <div>My Profile</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4">
                            <a href="{{ route('donor.about') }}" class="text-decoration-none">
                                <div class="p-3 border rounded hover-shadow">
                                    <i class="fas fa-info-circle fa-2x text-primary mb-2"></i>
                                    <div>About Us</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4">
                            <a href="{{ route('donor.contact') }}" class="text-decoration-none">
                                <div class="p-3 border rounded hover-shadow">
                                    <i class="fas fa-envelope fa-2x text-primary mb-2"></i>
                                    <div>Contact</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4">
                            <a href="{{ route('donor.donate.index') }}" class="text-decoration-none">
                                <div class="p-3 border rounded hover-shadow">
                                    <i class="fas fa-plus-circle fa-2x text-primary mb-2"></i>
                                    <div>New Donation</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-shadow {
        transition: all 0.3s ease;
    }
    .hover-shadow:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }
    .card {
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
    }
</style>
@endsection