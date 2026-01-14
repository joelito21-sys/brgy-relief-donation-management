@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="flex flex-col sm:flex-row items-center justify-between mb-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-4 sm:mb-0">Dashboard Overview</h1>
        <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition">
            <i class="fas fa-download mr-2"></i> Generate Report
        </a>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Residents -->
        <div class="bg-white rounded-lg shadow border-l-4 border-blue-500 h-full p-4 transform hover:-translate-y-1 transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xs font-bold text-blue-500 uppercase mb-1">Total Residents</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $stats['total_residents'] }}</div>
                </div>
                <div>
                    <i class="fas fa-users text-3xl text-gray-300"></i>
                </div>
            </div>
        </div>

        <!-- Pending Residents -->
        <div class="bg-white rounded-lg shadow border-l-4 border-yellow-500 h-full p-4 transform hover:-translate-y-1 transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xs font-bold text-yellow-500 uppercase mb-1">Pending Residents</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $stats['pending_residents'] }}</div>
                </div>
                <div>
                    <i class="fas fa-user-clock text-3xl text-gray-300"></i>
                </div>
            </div>
        </div>

        <!-- Total Donations -->
        <div class="bg-white rounded-lg shadow border-l-4 border-green-500 h-full p-4 transform hover:-translate-y-1 transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xs font-bold text-green-500 uppercase mb-1">Total Donations</div>
                    <div class="text-2xl font-bold text-gray-800">₱{{ number_format($stats['total_donations']['cash'], 2) }}</div>
                </div>
                <div>
                    <i class="fas fa-donate text-3xl text-gray-300"></i>
                </div>
            </div>
        </div>

        <!-- Pending Requests -->
        <div class="bg-white rounded-lg shadow border-l-4 border-cyan-500 h-full p-4 transform hover:-translate-y-1 transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xs font-bold text-cyan-500 uppercase mb-1">Pending Requests</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $stats['pending_requests'] }}</div>
                </div>
                <div>
                    <i class="fas fa-tasks text-3xl text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Access Navigation Grid -->
    <h2 class="text-lg font-bold text-gray-800 mb-4">Quick Access</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
        <!-- Manage Residents -->
        <a href="{{ route('admin.residents.index') }}" class="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 transition-all hover:-translate-y-1 group">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-xl group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="ml-3 font-bold text-gray-800 text-lg">Residents</h3>
            </div>
            <p class="text-sm text-gray-500">Manage resident profiles, approvals, and verify identities.</p>
        </a>

        <!-- Create Resident -->
        <a href="{{ route('admin.residents.create') }}" class="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 transition-all hover:-translate-y-1 group">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-xl group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h3 class="ml-3 font-bold text-gray-800 text-lg">Add Resident</h3>
            </div>
            <p class="text-sm text-gray-500">Register a new resident manually into the system.</p>
        </a>

        <!-- Donors -->
        <a href="{{ route('admin.donors.index') }}" class="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 transition-all hover:-translate-y-1 group">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-lg bg-pink-100 text-pink-600 flex items-center justify-center text-xl group-hover:bg-pink-600 group-hover:text-white transition-colors">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
                <h3 class="ml-3 font-bold text-gray-800 text-lg">Donors</h3>
            </div>
            <p class="text-sm text-gray-500">View and manage donor information and history.</p>
        </a>

        <!-- Donations Management -->
        <a href="{{ route('admin.donations.index') }}" class="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 transition-all hover:-translate-y-1 group">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-lg bg-green-100 text-green-600 flex items-center justify-center text-xl group-hover:bg-green-600 group-hover:text-white transition-colors">
                    <i class="fas fa-donate"></i>
                </div>
                <h3 class="ml-3 font-bold text-gray-800 text-lg">Donations</h3>
            </div>
            <p class="text-sm text-gray-500">Track incoming cash and in-kind donations.</p>
        </a>

        <!-- Relief Requests -->
        <a href="{{ route('admin.relief-requests.index') }}" class="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 transition-all hover:-translate-y-1 group">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center text-xl group-hover:bg-purple-600 group-hover:text-white transition-colors">
                    <i class="fas fa-hands-helping"></i>
                </div>
                <h3 class="ml-3 font-bold text-gray-800 text-lg">Relief Requests</h3>
            </div>
            <p class="text-sm text-gray-500">Process and fulfill assistance requests from residents.</p>
        </a>

        <!-- Inventory -->
        <a href="{{ route('admin.inventory.index') }}" class="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 transition-all hover:-translate-y-1 group">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center text-xl group-hover:bg-orange-600 group-hover:text-white transition-colors">
                    <i class="fas fa-boxes"></i>
                </div>
                <h3 class="ml-3 font-bold text-gray-800 text-lg">Inventory</h3>
            </div>
            <p class="text-sm text-gray-500">Monitor stock levels of relief goods and supplies.</p>
        </a>

        <!-- Distributions -->
        <a href="{{ route('admin.distributions.index') }}" class="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 transition-all hover:-translate-y-1 group">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-lg bg-teal-100 text-teal-600 flex items-center justify-center text-xl group-hover:bg-teal-600 group-hover:text-white transition-colors">
                    <i class="fas fa-truck"></i>
                </div>
                <h3 class="ml-3 font-bold text-gray-800 text-lg">Distributions</h3>
            </div>
            <p class="text-sm text-gray-500">Manage distribution schedules and notifications.</p>
        </a>

        <!-- Reports -->
        <a href="{{ route('admin.reports.index') }}" class="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 transition-all hover:-translate-y-1 group">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-lg bg-red-100 text-red-600 flex items-center justify-center text-xl group-hover:bg-red-600 group-hover:text-white transition-colors">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <h3 class="ml-3 font-bold text-gray-800 text-lg">Reports</h3>
            </div>
            <p class="text-sm text-gray-500">Generate and download detailed system reports.</p>
        </a>

        <!-- Analytics -->
        <a href="{{ route('admin.analytics') }}" class="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 transition-all hover:-translate-y-1 group">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-lg bg-cyan-100 text-cyan-600 flex items-center justify-center text-xl group-hover:bg-cyan-600 group-hover:text-white transition-colors">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="ml-3 font-bold text-gray-800 text-lg">Analytics</h3>
            </div>
            <p class="text-sm text-gray-500">Visual data insights and trends overview.</p>
        </a>

        <!-- Settings -->
        <a href="{{ route('admin.settings') }}" class="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 transition-all hover:-translate-y-1 group">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center text-xl group-hover:bg-gray-600 group-hover:text-white transition-colors">
                    <i class="fas fa-cog"></i>
                </div>
                <h3 class="ml-3 font-bold text-gray-800 text-lg">Settings</h3>
            </div>
            <p class="text-sm text-gray-500">Configure system preferences and accounts.</p>
        </a>
    </div>

    <!-- Content Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Donations -->
        <div class="bg-white shadow rounded-lg mb-4">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                <h6 class="m-0 font-bold text-blue-600">Recent Donations</h6>
                <a href="{{ route('admin.donations.index') }}" class="text-sm text-blue-500 hover:text-blue-700">View All</a>
            </div>
            <div class="p-4">
                @if(count($stats['recent_donations']) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ref #</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Donor</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($stats['recent_donations'] as $donation)
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $donation->reference_number ?? $donation->id }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-600">{{ $donation->donor->name ?? 'Anonymous' }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                                            @if($donation->type == 'cash')
                                                ₱{{ number_format($donation->amount, 2) }}
                                            @else
                                                In-Kind
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $donation->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                                   ($donation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                                                {{ ucfirst($donation->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No recent donations found.</p>
                @endif
            </div>
        </div>

        <!-- Pending Residents -->
        <div class="bg-white shadow rounded-lg mb-4">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                <h6 class="m-0 font-bold text-yellow-600">Pending Resident Verifications</h6>
                <a href="{{ route('admin.residents.index') }}" class="text-sm text-blue-500 hover:text-blue-700">View All</a>
            </div>
            <div class="p-4">
                @if(count($stats['pending_residents_list']) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barangay</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($stats['pending_residents_list'] as $resident)
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">{{ $resident->first_name }} {{ $resident->last_name }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">{{ $resident->barangay }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">{{ $resident->created_at->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No pending resident verifications.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection