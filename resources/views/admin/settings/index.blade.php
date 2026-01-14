@extends('admin.layouts.app')

@section('title', 'Settings')

@section('content')
<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="stat-card bg-gradient-to-r from-violet-500 to-violet-600 rounded-xl p-6 text-black">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-violet-100 text-sm">Site Settings</p>
               
                <p class="text-3xl font-bold mt-2 text-black">Configured</p>
            </div>
            <div class="bg-white/20 rounded-lg p-3">
                <i class="fas fa-cog text-2xl text-black"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-black">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm">Notifications</p>
               
                <p class="text-3xl font-bold mt-2 text-black">{{ $notificationSettings ?? 3 }}</p>
            </div>
            <div class="bg-white/20 rounded-lg p-3">
                <i class="fas fa-bell text-2xl text-black"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card bg-gradient-to-r from-amber-500 to-amber-600 rounded-xl p-6 text-black">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-amber-100 text-sm">Backup Status</p>
               
                <p class="text-3xl font-bold mt-2 text-black">Active</p>
            </div>
            <div class="bg-white/20 rounded-lg p-3">
                <i class="fas fa-shield-alt text-2xl text-black"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 text-black">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm">Last Updated</p>
                
                <p class="text-3xl font-bold mt-2 text-black">{{ $lastUpdated ?? 'Today' }}</p>
            </div>
            <div class="bg-white/20 rounded-lg p-3">
                <i class="fas fa-clock text-2xl text-black"></i>
            </div>
        </div>
    </div>
</div>

<!-- Main Settings Form -->
<div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-2xl border border-violet-200">
    <!-- Header -->
    <div class="border-b border-gray-200 p-6" style="background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);">
        <h2 class="text-xl font-bold text-white">Application Settings</h2>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="p-6">
        @csrf
        @method('PUT')
        
        <!-- Site Settings Section -->
        <div class="bg-gray-50 rounded-xl p-6 mb-6">
            <h3 class="text-lg font-bold text-black mb-6 flex items-center">
                <i class="fas fa-globe text-violet-600 mr-3"></i>
                Site Settings
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Site Name -->
                <div>
                    <label for="site_name" class="block text-sm font-bold text-black mb-2">
                        <i class="fas fa-tag mr-2 text-gray-400"></i>Site Name
                    </label>
                    <input type="text" 
                           id="site_name" 
                           name="site[name]" 
                           value="{{ old('site.name', $settings['site']['name'] ?? 'Flood Control System') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-colors text-black"
                           placeholder="Enter site name">
                </div>

                <!-- Contact Email -->
                <div>
                    <label for="site_email" class="block text-sm font-bold text-black mb-2">
                        <i class="fas fa-envelope mr-2 text-gray-400"></i>Contact Email
                    </label>
                    <input type="email" 
                           id="site_email" 
                           name="site[email]" 
                           value="{{ old('site.email', $settings['site']['email'] ?? 'admin@floodcontrol.com') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-colors text-black"
                           placeholder="admin@example.com">
                </div>

                <!-- Site Description -->
                <div class="md:col-span-2">
                    <label for="site_description" class="block text-sm font-bold text-black mb-2">
                        <i class="fas fa-align-left mr-2 text-gray-400"></i>Site Description
                    </label>
                    <textarea id="site_description" 
                              name="site[description]" 
                              rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-colors text-black"
                              placeholder="Describe your flood control system">{{ old('site.description', $settings['site']['description'] ?? 'Comprehensive flood management and relief distribution system') }}</textarea>
                </div>

                <!-- Timezone -->
                <div class="md:col-span-2">
                    <label for="timezone" class="block text-sm font-bold text-black mb-2">
                        <i class="fas fa-globe-americas mr-2 text-gray-400"></i>Timezone
                    </label>
                    <select id="timezone" 
                            name="site[timezone]" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-colors text-black">
                        <option value="">Select Timezone</option>
                        @foreach($timezones ?? ['Asia/Manila', 'Asia/Tokyo', 'Asia/Singapore', 'UTC', 'America/New_York', 'Europe/London'] as $timezone)
                            <option value="{{ $timezone }}" {{ ($settings['site']['timezone'] ?? 'Asia/Manila') === $timezone ? 'selected' : '' }}>
                                {{ $timezone }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Notification Settings Section -->
        <div class="bg-gray-50 rounded-xl p-6 mb-6">
            <h3 class="text-lg font-bold text-black mb-6 flex items-center">
                <i class="fas fa-bell text-violet-600 mr-3"></i>
                Notification Settings
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Enable Email Notifications -->
                <div class="flex items-center justify-between p-4 bg-white rounded-lg border border-gray-200">
                    <div class="flex items-center">
                        <i class="fas fa-envelope text-violet-500 mr-3"></i>
                        <div>
                            <p class="font-bold text-black">Enable Email Notifications</p>
                            <p class="text-sm text-gray-500">Receive notifications via email</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" 
                               name="notifications[email_enabled]" 
                               value="1" 
                               {{ old('notifications.email_enabled', $settings['notifications']['email_enabled'] ?? true) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-violet-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-violet-600"></div>
                    </label>
                </div>

                <!-- Enable SMS Notifications -->
                <div class="flex items-center justify-between p-4 bg-white rounded-lg border border-gray-200">
                    <div class="flex items-center">
                        <i class="fas fa-sms text-green-500 mr-3"></i>
                        <div>
                            <p class="font-bold text-black">Enable SMS Notifications</p>
                            <p class="text-sm text-gray-500">Receive notifications via SMS</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" 
                               name="notifications[sms_enabled]" 
                               value="1" 
                               {{ old('notifications.sms_enabled', $settings['notifications']['sms_enabled'] ?? false) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-violet-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-violet-600"></div>
                    </label>
                </div>

                <!-- Enable Push Notifications -->
                <div class="flex items-center justify-between p-4 bg-white rounded-lg border border-gray-200">
                    <div class="flex items-center">
                        <i class="fas fa-desktop text-purple-500 mr-3"></i>
                        <div>
                            <p class="font-bold text-black">Enable Push Notifications</p>
                            <p class="text-sm text-gray-500">Receive browser push notifications</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" 
                               name="notifications[push_enabled]" 
                               value="1" 
                               {{ old('notifications.push_enabled', $settings['notifications']['push_enabled'] ?? true) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-violet-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-violet-600"></div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Backup Settings Section -->
        <div class="bg-gray-50 rounded-xl p-6 mb-6">
            <h3 class="text-lg font-bold text-black mb-6 flex items-center">
                <i class="fas fa-shield-alt text-violet-600 mr-3"></i>
                Backup Settings
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Enable Automatic Backups -->
                <div class="flex items-center justify-between p-4 bg-white rounded-lg border border-gray-200">
                    <div class="flex items-center">
                        <i class="fas fa-robot text-violet-500 mr-3"></i>
                        <div>
                            <p class="font-bold text-black">Enable Automatic Backups</p>
                            <p class="text-sm text-gray-500">Automatically backup system data</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" 
                               name="backup[auto_enabled]" 
                               value="1" 
                               {{ old('backup.auto_enabled', $settings['backup']['auto_enabled'] ?? true) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-violet-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-violet-600"></div>
                    </label>
                </div>

                <!-- Backup Schedule -->
                <div>
                    <label for="backup_schedule" class="block text-sm font-bold text-black mb-2">
                        <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>Backup Schedule
                    </label>
                    <select id="backup_schedule" 
                            name="backup[schedule]" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-colors text-black">
                        <option value="daily" {{ old('backup.schedule', $settings['backup']['schedule'] ?? 'daily') === 'daily' ? 'selected' : '' }}>Daily</option>
                        <option value="weekly" {{ old('backup.schedule', $settings['backup']['schedule'] ?? 'daily') === 'weekly' ? 'selected' : '' }}>Weekly</option>
                        <option value="monthly" {{ old('backup.schedule', $settings['backup']['schedule'] ?? 'daily') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                    </select>
                </div>

                <!-- Retention Days -->
                <div>
                    <label for="retention_days" class="block text-sm font-bold text-black mb-2">
                        <i class="fas fa-history mr-2 text-gray-400"></i>Retention Days
                    </label>
                    <input type="number" 
                           id="retention_days" 
                           name="backup[retention_days]" 
                           value="{{ old('backup.retention_days', $settings['backup']['retention_days'] ?? 30) }}"
                           min="1"
                           max="365"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-colors text-black"
                           placeholder="30">
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
            <button type="button" 
                    onclick="window.location.reload()"
                    class="px-6 py-2 border border-gray-300 text-black rounded-lg hover:bg-gray-50 transition-colors font-bold">
                <i class="fas fa-times mr-2"></i>Cancel
            </button>
            <button type="submit" 
                    class="px-6 py-2 bg-gradient-to-r from-violet-600 to-violet-700 text-black rounded-lg hover:from-violet-700 hover:to-violet-800 transition-all transform hover:scale-105 shadow-lg font-bold">
                <i class="fas fa-save mr-2"></i>Save Settings
            </button>
        </div>
    </form>
</div>

<style>
    .stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        border-radius: 0.5rem;
        overflow: hidden;
        background: white;
        box-shadow: 0 0.15rem 1.75rem rgba(139, 92, 246, 0.15);
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(139, 92, 246, 0.3);
    }
    
    .bg-gradient-to-r {
        font-weight: 700; /* Bold text */
    }
    
    /* Make all text black except for stat cards */
    .text-gray-700, .text-gray-600, .text-gray-500 {
        color: black;
        font-weight: bold ;
    }
    
    .text-sm, .text-xs {
        font-weight: bold !important;
    }
    
    /* Ensure stat card text is white for visibility */
    .stat-card .text-3xl,
    .stat-card .text-white {
        color: black !important;
    }
    
    .stat-card .text-violet-100,
    .stat-card .text-green-100,
    .stat-card .text-amber-100,
    .stat-card .text-purple-100 {
        color: rgba(21, 18, 18, 0.8) !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-save indicator
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input, select, textarea');
    let saveTimeout;

    inputs.forEach(input => {
        input.addEventListener('change', function() {
            clearTimeout(saveTimeout);
            // Show unsaved changes indicator
            document.title = '* Settings - Flood Control';
        });
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
        submitBtn.disabled = true;
        
        // Reset after 3 seconds (in case of redirect)
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 3000);
    });
});
</script>
@endsection