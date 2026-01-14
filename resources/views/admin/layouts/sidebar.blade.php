@php
$navigation = [
    [
        'title' => 'Dashboard',
        'route' => 'admin.dashboard',
        'icon' => 'fas fa-tachometer-alt',
        'active' => request()->routeIs('admin.dashboard'),
    ],
    [
        'title' => 'Manage Residents',
        'route' => 'admin.residents.index',
        'icon' => 'fas fa-users',
        'active' => request()->Is('admin/residents*'),
    ],
    [
        'title' => 'Create Resident',
        'route' => 'admin.residents.create',
        'icon' => 'fas fa-user-plus',
        'active' => request()->routeIs('admin.residents.create'),
    ],
    [
        'title' => 'Donors',
        'route' => 'admin.donors.index',
        'icon' => 'fas fa-hand-holding-heart',
        'active' => request()->Is('admin/donors*'),
    ],
    [
        'title' => 'Donations',
        'route' => 'admin.donations.index',
        'icon' => 'fas fa-donate',
        'active' => request()->Is('admin/donations*'),
        'submenu' => [
            [
                'title' => 'Overview',
                'route' => 'admin.donations.index',
                'active' => request()->routeIs('admin.donations.index'),
            ],
            [
                'title' => 'GCash Account',
                'route' => 'admin.payment-accounts.gcash',
                'active' => request()->routeIs('admin.payment-accounts.gcash'),
            ],
            [
                'title' => 'PayMaya Account',
                'route' => 'admin.payment-accounts.paymaya',
                'active' => request()->routeIs('admin.payment-accounts.paymaya'),
            ],
            [
                'title' => 'Bank Account',
                'route' => 'admin.payment-accounts.bank',
                'active' => request()->routeIs('admin.payment-accounts.bank'),
            ],
        ],
    ],
    [
        'title' => 'Relief Requests',
        'route' => 'admin.relief-requests.index',
        'icon' => 'fas fa-hands-helping',
        'active' => request()->Is('admin/relief-requests*'),
    ],
    [
        'title' => 'Inventory',
        'route' => 'admin.inventory.index',
        'icon' => 'fas fa-boxes',
        'active' => request()->routeIs('admin.inventory.*'),
    ],
    [
        'title' => 'Distributions',
        'route' => 'admin.distributions.index',
        'icon' => 'fas fa-truck',
        'active' => request()->routeIs('admin.distributions.*'),
    ],
    [
        'title' => 'Appointment Schedule',
        'route' => 'admin.donations.type',
        'icon' => 'fas fa-calendar-check',
        'active' => request()->Is('admin/donations/type/cash*'),
        'route_params' => ['type' => 'cash'],
    ],
    [
        'title' => 'Notifications',
        'route' => 'admin.distribution-notifications.index',
        'icon' => 'fas fa-bell',
        'active' => request()->routeIs('admin.distribution-notifications.*'),
    ],
    [
        'title' => 'QR Scanner',
        'route' => 'admin.scanner.index',
        'icon' => 'fas fa-qrcode',
        'active' => request()->routeIs('admin.scanner.*'),
    ],
    [
        'title' => 'Reports',
        'route' => 'admin.reports.index',
        'icon' => 'fas fa-chart-bar',
        'active' => request()->routeIs('admin.reports.*'),
    ],
    [
        'title' => 'Analytics',
        'route' => 'admin.analytics',
        'icon' => 'fas fa-chart-line',
        'active' => request()->routeIs('admin.analytics'),
    ],
    [
        'title' => 'System Settings',
        'route' => 'admin.settings',
        'icon' => 'fas fa-cog',
        'active' => request()->routeIs('admin.settings'),
    ],
];
@endphp

<aside class="sidebar bg-white w-64 shadow-lg fixed h-full z-40 lg:z-0" 
       :class="{ 'mobile-show': sidebarOpen, 'collapsed': !sidebarOpen && !isMobile }"
       x-cloak>
    <!-- Logo -->
    <div class="p-4 border-b border-gray-200 flex items-center justify-between">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <x-application-logo class="h-8 w-auto text-indigo-600" />
            </div>
            <span class="logo-text ml-3 text-xl font-semibold text-gray-800">{{ config('app.name') }}</span>
        </div>
        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-500 hover:text-gray-700">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- User Profile -->
    @if(Auth::guard('admin')->check())
    <div class="p-4 border-b border-gray-200 flex items-center">
        <div class="flex-shrink-0">
            <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                <i class="fas fa-user"></i>
            </div>
        </div>
        <div class="ml-3 overflow-hidden">
            <p class="text-sm font-medium text-gray-700 truncate">{{ Auth::guard('admin')->user()->name }}</p>
            <p class="text-xs text-gray-500 truncate">{{ Auth::guard('admin')->user()->email }}</p>
        </div>
    </div>
    @else
    <div class="p-4 border-b border-gray-200">
        <p class="text-sm font-medium text-gray-700 text-center">Not Logged In</p>
    </div>
    @endif

    <!-- Navigation -->
    <nav class="mt-2 flex-1 overflow-y-auto">
        <ul class="px-2 space-y-1">
            @foreach($navigation as $item)
                <li>
                    @if(isset($item['submenu']))
                        <!-- Submenu Item -->
                        <div>
                            <button @click="submenuOpen = !submenuOpen" 
                                   class="group w-full flex items-center px-3 py-3 text-sm font-medium rounded-md transition-colors duration-200
                                          {{ $item['active'] ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                <i class="{{ $item['icon'] }} w-5 h-5 mr-3 flex-shrink-0 {{ $item['active'] ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                                <span class="nav-text">{{ $item['title'] }}</span>
                                <i class="fas fa-chevron-down ml-auto text-xs transition-transform duration-200" 
                                   :class="{ 'rotate-180': submenuOpen }"></i>
                            </button>
                            <div x-show="submenuOpen" x-transition:enter="transition ease-out duration-200" 
                                 x-transition:enter-start="opacity-0 transform -translate-y-1"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 transform translate-y-0"
                                 x-transition:leave-end="opacity-0 transform -translate-y-1"
                                 class="mt-1 space-y-1">
                                @foreach($item['submenu'] as $subitem)
                                    <a href="{{ route($subitem['route']) }}" 
                                       class="group flex items-center pl-11 pr-3 py-2 text-sm font-medium rounded-md transition-colors duration-200
                                              {{ $subitem['active'] ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                        <span class="nav-text">{{ $subitem['title'] }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <!-- Regular Menu Item -->
                        <a href="{{ isset($item['route_params']) ? route($item['route'], $item['route_params']) : route($item['route']) }}" 
                           class="group flex items-center px-3 py-3 text-sm font-medium rounded-md transition-colors duration-200
                                  {{ $item['active'] ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i class="{{ $item['icon'] }} w-5 h-5 mr-3 flex-shrink-0 {{ $item['active'] ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                            <span class="nav-text">{{ $item['title'] }}</span>
                            @if(isset($item['badge']))
                                <span class="ml-auto inline-block py-0.5 px-2.5 text-xs font-medium rounded-full {{ $item['active'] ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $item['badge'] }}
                                </span>
                            @endif
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    </nav>

    <!-- Spacer to separate navigation from logout -->
    <div class="pb-24"></div>

    <!-- Bottom Section -->
    <div class="p-4 border-t border-gray-200 absolute bottom-0 left-0 right-0">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" 
                    class="group w-full flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                <i class="fas fa-sign-out-alt w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500"></i>
                <span class="nav-text">Logout</span>
            </button>
        </form>
    </div>
</aside>
