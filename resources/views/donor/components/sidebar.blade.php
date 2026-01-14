<aside class="w-64 bg-gradient-to-b from-indigo-900 to-indigo-800 text-white h-screen fixed left-0 top-0 overflow-y-auto transition-all duration-300 ease-in-out shadow-2xl" id="sidebar">
    <div class="p-6 pb-24">
        <!-- Logo -->
        <div class="flex items-center justify-between mb-8">
            <a href="{{ route('donor.dashboard') }}" class="text-2xl font-bold flex flex-col items-start group">
                <div class="flex items-center mb-2">
                    <div class="relative">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-10 rounded-lg shadow-lg transition-transform group-hover:scale-105">
                        <div class="absolute -inset-1 bg-white/20 rounded-lg blur-sm"></div>
                    </div>
                </div>
                <span class="text-sm font-bold bg-gradient-to-r from-white to-indigo-200 bg-clip-text text-transparent leading-tight w-full whitespace-normal">Barangay Cubacub Relief and Donation Management Program</span>
            </a>
            <button class="lg:hidden p-2 rounded-lg hover:bg-indigo-700 transition-colors" id="closeSidebar">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="space-y-1">
            <a href="{{ route('donor.dashboard') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('donor.dashboard') ? 'bg-white/20 shadow-lg backdrop-blur-sm border border-white/30' : 'hover:bg-white/10 hover:translate-x-1' }}">
                <div class="relative">
                    <i class="fas fa-home mr-3 text-lg {{ request()->routeIs('donor.dashboard') ? 'text-white' : 'text-indigo-200 group-hover:text-white' }}"></i>
                    @if(request()->routeIs('donor.dashboard'))
                        <div class="absolute -inset-1 bg-white/30 rounded-full blur-md"></div>
                    @endif
                </div>
                <span class="font-medium {{ request()->routeIs('donor.dashboard') ? 'text-white' : 'text-indigo-100 group-hover:text-white' }}">Dashboard</span>
                @if(request()->routeIs('donor.dashboard'))
                    <div class="ml-auto w-2 h-2 bg-white rounded-full shadow-lg shadow-white/50"></div>
                @endif
            </a>
            
            <a href="{{ route('donor.donations.history') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('donor.donations.*') ? 'bg-white/20 shadow-lg backdrop-blur-sm border border-white/30' : 'hover:bg-white/10 hover:translate-x-1' }}">
                <div class="relative">
                    <i class="fas fa-history mr-3 text-lg {{ request()->routeIs('donor.donations.*') ? 'text-white' : 'text-indigo-200 group-hover:text-white' }}"></i>
                    @if(request()->routeIs('donor.donations.*'))
                        <div class="absolute -inset-1 bg-white/30 rounded-full blur-md"></div>
                    @endif
                </div>
                <span class="font-medium {{ request()->routeIs('donor.donations.*') ? 'text-white' : 'text-indigo-100 group-hover:text-white' }}">Donation History</span>
                @if(request()->routeIs('donor.donations.*'))
                    <div class="ml-auto w-2 h-2 bg-white rounded-full shadow-lg shadow-white/50"></div>
                @endif
            </a>
            
            <a href="{{ route('donor.profile') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('donor.profile') ? 'bg-white/20 shadow-lg backdrop-blur-sm border border-white/30' : 'hover:bg-white/10 hover:translate-x-1' }}">
                <div class="relative">
                    <i class="fas fa-user mr-3 text-lg {{ request()->routeIs('donor.profile') ? 'text-white' : 'text-indigo-200 group-hover:text-white' }}"></i>
                    @if(request()->routeIs('donor.profile'))
                        <div class="absolute -inset-1 bg-white/30 rounded-full blur-md"></div>
                    @endif
                </div>
                <span class="font-medium {{ request()->routeIs('donor.profile') ? 'text-white' : 'text-indigo-100 group-hover:text-white' }}">My Profile</span>
                @if(request()->routeIs('donor.profile'))
                    <div class="ml-auto w-2 h-2 bg-white rounded-full shadow-lg shadow-white/50"></div>
                @endif
            </a>
            
            <a href="{{ route('donor.activities') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('donor.activities') ? 'bg-white/20 shadow-lg backdrop-blur-sm border border-white/30' : 'hover:bg-white/10 hover:translate-x-1' }}">
                <div class="relative">
                    <i class="fas fa-tasks mr-3 text-lg {{ request()->routeIs('donor.activities') ? 'text-white' : 'text-indigo-200 group-hover:text-white' }}"></i>
                    @if(request()->routeIs('donor.activities'))
                        <div class="absolute -inset-1 bg-white/30 rounded-full blur-md"></div>
                    @endif
                </div>
                <span class="font-medium {{ request()->routeIs('donor.activities') ? 'text-white' : 'text-indigo-100 group-hover:text-white' }}">Activities</span>
                @if(request()->routeIs('donor.activities'))
                    <div class="ml-auto w-2 h-2 bg-white rounded-full shadow-lg shadow-white/50"></div>
                @endif
            </a>
            
            <div class="pt-4 mt-4 border-t border-indigo-700">
                <a href="{{ route('donor.about') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('donor.about') ? 'bg-white/20 shadow-lg backdrop-blur-sm border border-white/30' : 'hover:bg-white/10 hover:translate-x-1' }}">
                    <div class="relative">
                        <i class="fas fa-info-circle mr-3 text-lg {{ request()->routeIs('donor.about') ? 'text-white' : 'text-indigo-200 group-hover:text-white' }}"></i>
                        @if(request()->routeIs('donor.about'))
                            <div class="absolute -inset-1 bg-white/30 rounded-full blur-md"></div>
                        @endif
                    </div>
                    <span class="font-medium {{ request()->routeIs('donor.about') ? 'text-white' : 'text-indigo-100 group-hover:text-white' }}">About Us</span>
                    @if(request()->routeIs('donor.about'))
                        <div class="ml-auto w-2 h-2 bg-white rounded-full shadow-lg shadow-white/50"></div>
                    @endif
                </a>
                
                <a href="{{ route('donor.contact') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('donor.contact') ? 'bg-white/20 shadow-lg backdrop-blur-sm border border-white/30' : 'hover:bg-white/10 hover:translate-x-1' }}">
                    <div class="relative">
                        <i class="fas fa-envelope mr-3 text-lg {{ request()->routeIs('donor.contact') ? 'text-white' : 'text-indigo-200 group-hover:text-white' }}"></i>
                        @if(request()->routeIs('donor.contact'))
                            <div class="absolute -inset-1 bg-white/30 rounded-full blur-md"></div>
                        @endif
                    </div>
                    <span class="font-medium {{ request()->routeIs('donor.contact') ? 'text-white' : 'text-indigo-100 group-hover:text-white' }}">Contact Us</span>
                    @if(request()->routeIs('donor.contact'))
                        <div class="ml-auto w-2 h-2 bg-white rounded-full shadow-lg shadow-white/50"></div>
                    @endif
                </a>
            </div>
        </nav>
    </div>

    <!-- User Profile -->
    <div class="absolute bottom-0 left-0 right-0 p-6 border-t border-indigo-700 bg-gradient-to-t from-indigo-900/50 to-transparent">
        <div class="flex items-center p-3 rounded-xl bg-white/10 backdrop-blur-sm border border-white/20">
            <div class="relative">
                <img src="{{ Auth::guard('donor')->user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::guard('donor')->user()->name).'&background=6366f1&color=fff' }}" 
                     alt="User" 
                     class="h-12 w-12 rounded-full object-cover ring-2 ring-white/30 ring-offset-2 ring-offset-indigo-800">
                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-indigo-800"></div>
            </div>
            <div class="ml-3 flex-1">
                <p class="text-sm font-semibold text-white">{{ Auth::guard('donor')->user()->name }}</p>
                <p class="text-xs text-indigo-200 flex items-center">
                    <i class="fas fa-heart mr-1 text-red-400"></i>
                    Donor
                </p>
            </div>
            <form method="POST" action="{{ route('donor.logout') }}" class="ml-auto">
                @csrf
                <button type="submit" class="p-2 rounded-lg hover:bg-white/20 transition-colors group">
                    <i class="fas fa-sign-out-alt text-indigo-200 group-hover:text-white"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- Mobile menu button -->
<button class="fixed top-6 right-6 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white p-3 rounded-xl shadow-2xl lg:hidden z-50 hover:shadow-3xl hover:scale-105 transition-all duration-200 border border-white/20 backdrop-blur-sm" id="mobileMenuButton">
    <i class="fas fa-bars text-lg"></i>
    <div class="absolute -inset-1 bg-indigo-400/20 rounded-xl blur-md"></div>
</button>

<!-- Mobile overlay -->
<div id="mobileOverlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm lg:hidden z-40 hidden transition-opacity duration-300"></div>

<script>
    // Toggle sidebar on mobile
    const sidebar = document.getElementById('sidebar');
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const closeSidebar = document.getElementById('closeSidebar');
    const mobileOverlay = document.getElementById('mobileOverlay');
    
    // Initialize sidebar state
    sidebar.classList.add('-translate-x-full');
    
    mobileMenuButton.addEventListener('click', () => {
        const isOpen = !sidebar.classList.contains('-translate-x-full');
        if (isOpen) {
            closeSidebarFunc();
        } else {
            openSidebarFunc();
        }
    });
    
    closeSidebar.addEventListener('click', closeSidebarFunc);
    
    mobileOverlay.addEventListener('click', closeSidebarFunc);
    
    function openSidebarFunc() {
        sidebar.classList.remove('-translate-x-full');
        mobileOverlay.classList.remove('hidden');
        setTimeout(() => {
            mobileOverlay.classList.add('opacity-100');
            mobileOverlay.classList.remove('opacity-0');
        }, 10);
        // Change button to close icon
        mobileMenuButton.innerHTML = '<i class="fas fa-times text-lg"></i><div class="absolute -inset-1 bg-red-400/20 rounded-xl blur-md"></div>';
    }
    
    function closeSidebarFunc() {
        sidebar.classList.add('-translate-x-full');
        mobileOverlay.classList.remove('opacity-100');
        mobileOverlay.classList.add('opacity-0');
        setTimeout(() => {
            mobileOverlay.classList.add('hidden');
        }, 300);
        // Change button back to menu icon
        mobileMenuButton.innerHTML = '<i class="fas fa-bars text-lg"></i><div class="absolute -inset-1 bg-indigo-400/20 rounded-xl blur-md"></div>';
    }
    
    // Close sidebar on window resize if desktop
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) {
            sidebar.classList.remove('-translate-x-full');
            mobileOverlay.classList.add('hidden');
            mobileMenuButton.innerHTML = '<i class="fas fa-bars text-lg"></i><div class="absolute -inset-1 bg-indigo-400/20 rounded-xl blur-md"></div>';
        } else {
            sidebar.classList.add('-translate-x-full');
        }
    });
    
    // Close sidebar on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
            closeSidebarFunc();
        }
    });
</script>
