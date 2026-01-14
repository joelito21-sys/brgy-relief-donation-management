<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of announcements.
     */
    public function index(Request $request)
    {
        $query = Announcement::with('admin')->latest();

        // Apply filters
        if ($request->has('type') && $request->type) {
            $query->ofType($request->type);
        }

        if ($request->has('status') && $request->status) {
            if ($request->status === 'active') {
                $query->active();
            } else {
                $query->where('is_active', false);
            }
        }

        $announcements = $query->paginate(15);

        // Get statistics
        $stats = [
            'total' => Announcement::count(),
            'active' => Announcement::active()->count(),
            'relief_goods' => Announcement::ofType('relief_goods')->count(),
            'feeding_program' => Announcement::ofType('feeding_program')->count(),
            'emergency' => Announcement::ofType('emergency')->count(),
        ];

        return view('admin.announcements.index', compact('announcements', 'stats'));
    }

    /**
     * Show the form for creating a new announcement.
     */
    public function create()
    {
        return view('admin.announcements.create');
    }

    /**
     * Store a newly created announcement.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:relief_goods,feeding_program,general,emergency',
            'location' => 'nullable|string|max:255',
            'scheduled_at' => 'nullable|date|after_or_equal:now',
            'is_active' => 'boolean',
        ]);

        $validated['admin_id'] = Auth::guard('admin')->id();
        $validated['is_active'] = $request->has('is_active');

        try {
            Announcement::create($validated);

            return redirect()
                ->route('admin.announcements.index')
                ->with('success', 'Announcement created successfully!');

        } catch (\Exception $e) {
            \Log::error('Error creating announcement: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create announcement. Please try again.');
        }
    }

    /**
     * Display the specified announcement.
     */
    public function show($id)
    {
        $announcement = Announcement::with('admin')->findOrFail($id);
        return view('admin.announcements.show', compact('announcement'));
    }

    /**
     * Show the form for editing the specified announcement.
     */
    public function edit($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('admin.announcements.edit', compact('announcement'));
    }

    /**
     * Update the specified announcement.
     */
    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:relief_goods,feeding_program,general,emergency',
            'location' => 'nullable|string|max:255',
            'scheduled_at' => 'nullable|date|after_or_equal:now',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        try {
            $announcement->update($validated);

            return redirect()
                ->route('admin.announcements.index')
                ->with('success', 'Announcement updated successfully!');

        } catch (\Exception $e) {
            \Log::error('Error updating announcement: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update announcement. Please try again.');
        }
    }

    /**
     * Remove the specified announcement.
     */
    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);

        try {
            $announcement->delete();

            return redirect()
                ->route('admin.announcements.index')
                ->with('success', 'Announcement deleted successfully!');

        } catch (\Exception $e) {
            \Log::error('Error deleting announcement: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Failed to delete announcement. Please try again.');
        }
    }

    /**
     * Toggle announcement status.
     */
    public function toggleStatus($id)
    {
        $announcement = Announcement::findOrFail($id);

        try {
            $announcement->update([
                'is_active' => !$announcement->is_active
            ]);

            $status = $announcement->is_active ? 'activated' : 'deactivated';

            return redirect()
                ->back()
                ->with('success', "Announcement {$status} successfully!");

        } catch (\Exception $e) {
            \Log::error('Error toggling announcement status: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Failed to toggle announcement status. Please try again.');
        }
    }
}
