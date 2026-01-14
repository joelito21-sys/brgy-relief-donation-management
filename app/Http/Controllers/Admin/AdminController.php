<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Donation;
use App\Models\ReliefRequest;
use App\Models\Report;
use App\Models\Event;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        $stats = [
            'total_donors' => Donation::distinct('donor_id')->count(),
            'pending_requests' => ReliefRequest::where('status', 'pending')->count(),
            'total_donations' => [
                'food' => Donation::where('type', 'food')->sum('quantity'),
                'clothes' => Donation::where('type', 'clothes')->sum('quantity'),
                'medical' => Donation::where('type', 'medical')->sum('quantity'),
                'cash' => Donation::where('type', 'cash')->sum('amount'),
            ],
            'recent_activities' => ActivityLog::latest()->take(10)->get(),
            'urgent_reports' => Report::where('priority', 'high')
                ->where('status', '!=', 'resolved')
                ->with('reporter')
                ->latest()
                ->take(5)
                ->get(),
        ];

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats
        ]);
    }

    /**
     * Display a listing of the admins.
     */
    public function index()
    {
        $admins = Admin::latest()->paginate(10);
        return Inertia::render('Admin/Admins/Index', [
            'admins' => $admins
        ]);
    }

    /**
     * Show the form for creating a new admin.
     */
    public function create()
    {
        return Inertia::render('Admin/Admins/Create');
    }

    /**
     * Store a newly created admin in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'is_super_admin' => 'boolean',
        ]);

        $admin = Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'is_super_admin' => $validated['is_super_admin'] ?? false,
            'status' => 'active',
        ]);

        activity()
            ->causedBy(auth('admin')->user())
            ->performedOn($admin)
            ->log('created admin account');

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin created successfully.');
    }

    /**
     * Display the specified admin.
     */
    public function show(Admin $admin)
    {
        return Inertia::render('Admin/Admins/Show', [
            'admin' => $admin->load('activityLogs')
        ]);
    }

    /**
     * Show the form for editing the specified admin.
     */
    public function edit(Admin $admin)
    {
        return Inertia::render('Admin/Admins/Edit', [
            'admin' => $admin
        ]);
    }

    /**
     * Update the specified admin in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('admins')->ignore($admin->id),
            ],
            'phone' => 'required|string|max:20',
            'is_super_admin' => 'boolean',
            'status' => 'required|in:active,inactive',
        ]);

        $admin->update($validated);

        activity()
            ->causedBy(auth('admin')->user())
            ->performedOn($admin)
            ->log('updated admin account');

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin updated successfully.');
    }

    /**
     * Remove the specified admin from storage.
     */
    public function destroy(Admin $admin)
    {
        // Prevent deleting own account
        if ($admin->id === auth('admin')->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $admin->delete();

        activity()
            ->causedBy(auth('admin')->user())
            ->log('deleted admin account');

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin deleted successfully.');
    }

    /**
     * Show the admin's profile page.
     */
    public function profile()
    {
        return Inertia::render('Admin/Profile/Show', [
            'admin' => auth('admin')->user()
        ]);
    }

    /**
     * Update the admin's profile information.
     */
    public function updateProfile(Request $request)
    {
        $admin = auth('admin')->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('admins')->ignore($admin->id),
            ],
            'phone' => 'required|string|max:20',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ];

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $updateData['profile_photo_path'] = $path;
        }

        $admin->update($updateData);

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Update the admin's password.
     */
    public function updatePassword(Request $request)
    {
        $admin = auth('admin')->user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password:admin'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $admin->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }

    /**
     * Get the admin's activity logs.
     */
    public function activityLogs()
    {
        $logs = ActivityLog::where('causer_type', Admin::class)
            ->where('causer_id', auth('admin')->id())
            ->latest()
            ->paginate(20);

        return Inertia::render('Admin/ActivityLogs/Index', [
            'logs' => $logs
        ]);
    }
}
