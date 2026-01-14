@extends('admin.layouts.app')

@section('title', 'View Donor')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Donor Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.donors.edit', $donor) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.donors.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Name:</th>
                                    <td>{{ $donor->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $donor->email }}</td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td>{{ $donor->phone }}</td>
                                </tr>
                                @if($donor->organization)
                                <tr>
                                    <th>Organization:</th>
                                    <td>{{ $donor->organization }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Address:</th>
                                    <td>{{ $donor->address }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge badge-{{ $donor->status === 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($donor->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Account Created:</th>
                                    <td>{{ $donor->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated:</th>
                                    <td>{{ $donor->updated_at->format('M d, Y h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="mb-3">
                                <div class="img-thumbnail" style="width: 200px; height: 200px; margin: 0 auto; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;">
                                    <i class="fas fa-user-circle" style="font-size: 100px; color: #6c757d;"></i>
                                </div>
                            </div>
                            <form action="{{ route('admin.donors.toggle-status', $donor) }}" method="POST" class="mb-3">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-{{ $donor->status === 'active' ? 'warning' : 'success' }} btn-block">
                                    <i class="fas {{ $donor->status === 'active' ? 'fa-user-times' : 'fa-user-check' }}"></i>
                                    {{ $donor->status === 'active' ? 'Deactivate' : 'Activate' }} Donor
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }
    .card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
    }
    .table th {
        background-color: #f8f9fc;
    }
</style>
@endpush
