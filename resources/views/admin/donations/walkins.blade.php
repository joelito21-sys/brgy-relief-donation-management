@extends('admin.layouts.app')

@section('title', 'Walk-in Appointments')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Home</a>
    <i class="fas fa-chevron-right text-xs"></i>
    <a href="{{ route('admin.donations.index') }}">Donations</a>
    <i class="fas fa-chevron-right text-xs"></i>
    <span>Walk-in Appointments</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Walk-in Appointments</h1>
            <p class="mt-2 text-sm text-gray-600">Manage pending walk-in donation appointments</p>
        </div>
    </div>

    <!-- Appointments Table -->
    <div class="card bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date/Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Donor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purpose</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($appointments as $appointment)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $appointment->payment_details['appointment_date'] ?? 'N/A' }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $appointment->payment_details['appointment_time'] ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $appointment->donor_name }}</div>
                                <div class="text-sm text-gray-500">{{ $appointment->donor_email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ ucfirst($appointment->payment_details['appointment_type'] ?? 'N/A') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $appointment->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $appointment->status === 'completed' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $appointment->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.donations.show', $appointment->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                <!-- Add Respond Button logic later or just email link -->
                                <a href="mailto:{{ $appointment->donor_email }}?subject=Re: Walk-in Appointment {{ $appointment->reference_number }}" class="text-green-600 hover:text-green-900">Respond</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No walk-in appointments found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $appointments->links() }}
        </div>
    </div>
</div>
@endsection
