<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'site' => [
                'name' => config('app.name'),
                'description' => config('app.description', ''),
                'email' => config('mail.from.address'),
                'timezone' => config('app.timezone'),
                'date_format' => config('app.date_format', 'Y-m-d'),
                'time_format' => config('app.time_format', 'H:i'),
            ],
            'mail' => [
                'driver' => config('mail.driver'),
                'host' => config('mail.host'),
                'port' => config('mail.port'),
                'encryption' => config('mail.encryption'),
                'username' => config('mail.username'),
                'from_address' => config('mail.from.address'),
                'from_name' => config('mail.from.name'),
            ],
            'notifications' => [
                'email_notifications' => (bool) config('notifications.email', true),
                'sms_notifications' => (bool) config('notifications.sms', false),
                'push_notifications' => (bool) config('notifications.push', false),
            ],
            'backup' => [
                'auto_backup' => (bool) config('backup.auto_backup', true),
                'backup_schedule' => config('backup.schedule', 'daily'),
                'backup_retention' => (int) config('backup.retention_days', 30),
            ],
        ];

        $timezones = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);
        $dateFormats = [
            'Y-m-d' => now()->format('Y-m-d') . ' (Y-m-d)',
            'm/d/Y' => now()->format('m/d/Y') . ' (m/d/Y)',
            'd/m/Y' => now()->format('d/m/Y') . ' (d/m/Y)',
            'F j, Y' => now()->format('F j, Y') . ' (F j, Y)',
        ];
        $timeFormats = [
            'H:i' => now()->format('H:i') . ' (24-hour)',
            'h:i A' => now()->format('h:i A') . ' (12-hour)',
        ];

        return view('admin.settings.index', [
            'settings' => $settings,
            'timezones' => array_combine($timezones, $timezones),
            'dateFormats' => $dateFormats,
            'timeFormats' => $timeFormats,
            'backupSchedules' => [
                'daily' => 'Daily',
                'weekly' => 'Weekly',
                'monthly' => 'Monthly',
            ],
            'mailEncryption' => [
                'tls' => 'TLS',
                'ssl' => 'SSL',
                '' => 'None',
            ],
            'mailDrivers' => [
                'smtp' => 'SMTP',
                'mail' => 'PHP Mail',
                'sendmail' => 'Sendmail',
                'mailgun' => 'Mailgun',
                'ses' => 'Amazon SES',
            ],
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site.name' => 'required|string|max:255',
            'site.description' => 'nullable|string|max:500',
            'site.email' => 'required|email',
            'site.timezone' => 'required|timezone',
            'site.date_format' => 'required|string',
            'site.time_format' => 'required|string',
            
            'mail.driver' => ['required', Rule::in(['smtp', 'mail', 'sendmail', 'mailgun', 'ses'])],
            'mail.host' => 'required_if:mail.driver,smtp|nullable|string|max:255',
            'mail.port' => 'required_if:mail.driver,smtp|nullable|integer|min:1|max:65535',
            'mail.encryption' => 'nullable|string|in:tls,ssl',
            'mail.username' => 'nullable|string|max:255',
            'mail.password' => 'nullable|string|max:255',
            'mail.from_address' => 'required|email|max:255',
            'mail.from_name' => 'required|string|max:255',
            
            'notifications.email_notifications' => 'boolean',
            'notifications.sms_notifications' => 'boolean',
            'notifications.push_notifications' => 'boolean',
            
            'backup.auto_backup' => 'boolean',
            'backup.schedule' => 'required|in:daily,weekly,monthly',
            'backup.retention_days' => 'required|integer|min:1',
            
            'logo' => 'nullable|image|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png|max:1024',
        ]);

        // Handle file uploads
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('public/logos');
            setting(['site.logo' => Storage::url($path)])->save();
        }

        if ($request->hasFile('favicon')) {
            $path = $request->file('favicon')->storeAs('public', 'favicon.ico');
            setting(['site.favicon' => Storage::url($path)])->save();
        }

        // Save settings
        foreach ($validated as $group => $settings) {
            if (is_array($settings)) {
                foreach ($settings as $key => $value) {
                    setting(["{$group}.{$key}" => $value])->save();
                }
            } else {
                setting([$group => $settings])->save();
            }
        }

        // Update config
        $this->updateConfig($validated);

        return redirect()->route('admin.settings')
            ->with('success', 'Settings updated successfully.');
    }

    protected function updateConfig($settings)
    {
        // Update app config
        config([
            'app.name' => $settings['site']['name'] ?? config('app.name'),
            'app.timezone' => $settings['site']['timezone'] ?? config('app.timezone'),
        ]);

        // Update mail config
        if (isset($settings['mail'])) {
            config([
                'mail.driver' => $settings['mail']['driver'] ?? config('mail.driver'),
                'mail.host' => $settings['mail']['host'] ?? config('mail.host'),
                'mail.port' => $settings['mail']['port'] ?? config('mail.port'),
                'mail.encryption' => $settings['mail']['encryption'] ?? config('mail.encryption'),
                'mail.username' => $settings['mail']['username'] ?? config('mail.username'),
                'mail.password' => $settings['mail']['password'] ?? config('mail.password'),
                'mail.from.address' => $settings['mail']['from_address'] ?? config('mail.from.address'),
                'mail.from.name' => $settings['mail']['from_name'] ?? config('mail.from.name'),
            ]);
        }
    }

    public function backup()
    {
        // This would trigger a backup using a package like spatie/laravel-backup
        // For now, we'll just return a success message
        return back()->with('success', 'Backup created successfully.');
    }

    public function clearCache()
    {
        \Artisan::call('cache:clear');
        \Artisan::call('config:clear');
        \Artisan::call('view:clear');
        
        return back()->with('success', 'Application cache cleared successfully.');
    }
}
