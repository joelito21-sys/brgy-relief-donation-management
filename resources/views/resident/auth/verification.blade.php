<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Verification - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .spinner {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <div class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-white shadow-lg mb-6">
                <i class="fas fa-hourglass-half text-indigo-600 text-2xl spinner"></i>
            </div>
            
            <h2 class="text-3xl font-extrabold text-white mb-4">
                Account Verification
            </h2>
            
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 mb-6">
                <div class="flex items-center justify-center mb-4">
                    <i class="fas fa-clock text-yellow-300 text-4xl"></i>
                </div>
                
                <h3 class="text-xl font-semibold text-white mb-2">
                    Waiting for Admin Review
                </h3>
                
                <p class="text-indigo-100 text-sm mb-4">
                    Your registration has been submitted successfully and is currently under review by our administration team.
                </p>
                
                <div class="bg-white/20 rounded-lg p-4 mb-4">
                    <h4 class="text-white font-medium mb-2">What happens next?</h4>
                    <ul class="text-indigo-100 text-sm space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-300 mt-1 mr-2"></i>
                            <span>Admin will review your registration details</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-300 mt-1 mr-2"></i>
                            <span>You'll receive an email notification once approved</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-300 mt-1 mr-2"></i>
                            <span>After approval, you can access your dashboard</span>
                        </li>
                    </ul>
                </div>
                
                @if(auth()->guard('resident')->user())
                    <div class="bg-white/20 rounded-lg p-4">
                        <h4 class="text-white font-medium mb-2">Registration Details</h4>
                        <div class="text-left text-indigo-100 text-sm space-y-1">
                            @php
                                $resident = auth()->guard('resident')->user();
                                // Handle cases where first_name and last_name might be duplicated
                                $displayName = trim($resident->first_name . ' ' . $resident->last_name);
                                // Remove duplicate names if they're the same
                                if ($resident->first_name === $resident->last_name) {
                                    $displayName = $resident->first_name;
                                } elseif (strpos($resident->first_name, $resident->last_name) !== false) {
                                    $displayName = $resident->first_name;
                                } elseif (strpos($resident->last_name, $resident->first_name) !== false) {
                                    $displayName = $resident->last_name;
                                }
                            @endphp
                            <p><strong>Name:</strong> {{ $displayName }}</p>
                            <p><strong>Email:</strong> {{ $resident->email }}</p>
                            <p><strong>Submitted:</strong> {{ $resident->created_at->format('M d, Y - h:i A') }}</p>
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="space-y-4">
                <button onclick="location.reload()" class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Check Status
                </button>
                
                <form action="{{ route('resident.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-white/30 text-sm font-medium rounded-md text-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white transition duration-150 ease-in-out">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </button>
                </form>
            </div>
            
            <div class="mt-6">
                <a href="{{ route('home') }}" class="text-indigo-100 hover:text-white text-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Home
                </a>
            </div>
        </div>
    </div>

    <script>
        // Auto-refresh every 30 seconds
        setTimeout(function() {
            location.reload();
        }, 30000);
        
        // Check if user is approved and redirect
        @if(auth()->guard('resident')->user() && auth()->guard('resident')->user()->isApproved())
            window.location.href = "{{ route('resident.dashboard') }}";
        @endif
    </script>
</body>
</html>