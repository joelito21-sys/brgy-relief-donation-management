<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ResidentManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Show the form for creating a new resident.
     */
    public function create()
    {
        return view('admin.residents.create');
    }

    /**
     * Store a newly created resident in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:residents',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'barangay' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'id_number' => 'required|string|max:50',
            'id_type' => 'required|string|in:passport,driver_license,sss,voters_id,philhealth,others',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:20',
        ]);

        // Hash the password
        $validated['password'] = Hash::make($validated['password']);
        
        // Set approval status to approved since admin is creating
        $validated['approval_status'] = Resident::STATUS_APPROVED;

        Resident::create($validated);

        return redirect()->route('admin.residents.index')
            ->with('success', 'Resident created successfully.');
    }

    /**
     * Display a listing of residents with registration status.
     */
    public function index(Request $request)
    {
        $query = Resident::query();

        // Filter by approval status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('approval_status', $request->status);
        }

        // Search by name or email
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $residents = $query->latest()->paginate(10);

        $stats = [
            'total' => Resident::count(),
            'pending' => Resident::where('approval_status', Resident::STATUS_PENDING)->count(),
            'approved' => Resident::where('approval_status', Resident::STATUS_APPROVED)->count(),
            'rejected' => Resident::where('approval_status', Resident::STATUS_REJECTED)->count(),
        ];

        return view('admin.residents.index', compact('residents', 'stats'));
    }

    /**
     * Display the specified resident.
     */
    public function show(Resident $resident)
    {
        return view('admin.residents.show', compact('resident'));
    }

    /**
     * Approve a resident registration.
     */
    public function approve(Resident $resident)
    {
        if ($resident->isApproved()) {
            return back()->with('error', 'Resident is already approved.');
        }

        $resident->approve();

        // Log the activity
        activity()
            ->causedBy(auth('admin')->user())
            ->performedOn($resident)
            ->log('approved resident registration');

        return back()->with('success', 'Resident registration approved successfully.');
    }

    /**
     * Reject a resident registration.
     */
    public function reject(Request $request, Resident $resident)
    {
        if ($resident->isRejected()) {
            return back()->with('error', 'Resident is already rejected.');
        }

        $validated = $request->validate([
            'rejection_reason' => 'nullable|string|max:500',
        ]);

        $resident->reject();

        // Store rejection reason if provided
        if ($validated['rejection_reason']) {
            $resident->rejection_reason = $validated['rejection_reason'];
            $resident->save();
        }

        // Log the activity
        activity()
            ->causedBy(auth('admin')->user())
            ->performedOn($resident)
            ->log('rejected resident registration');

        return back()->with('success', 'Resident registration rejected successfully.');
    }

    /**
     * Bulk approve residents.
     */
    public function bulkApprove(Request $request)
    {
        $validated = $request->validate([
            'resident_ids' => 'required|array',
            'resident_ids.*' => 'exists:residents,id',
        ]);

        $count = 0;
        foreach ($validated['resident_ids'] as $id) {
            $resident = Resident::find($id);
            if ($resident && $resident->isPending()) {
                $resident->approve();
                $count++;
                
                // Log the activity
                activity()
                    ->causedBy(auth('admin')->user())
                    ->performedOn($resident)
                    ->log('approved resident registration');
            }
        }

        return back()->with('success', "Successfully approved {$count} resident(s).");
    }

    /**
     * Bulk reject residents.
     */
    public function bulkReject(Request $request)
    {
        $validated = $request->validate([
            'resident_ids' => 'required|array',
            'resident_ids.*' => 'exists:residents,id',
            'rejection_reason' => 'nullable|string|max:500',
        ]);

        $count = 0;
        foreach ($validated['resident_ids'] as $id) {
            $resident = Resident::find($id);
            if ($resident && $resident->isPending()) {
                $resident->reject();
                if ($validated['rejection_reason']) {
                    $resident->rejection_reason = $validated['rejection_reason'];
                    $resident->save();
                }
                $count++;
                
                // Log the activity
                activity()
                    ->causedBy(auth('admin')->user())
                    ->performedOn($resident)
                    ->log('rejected resident registration');
            }
        }

        return back()->with('success', "Successfully rejected {$count} resident(s).");
    }

    /**
     * Delete a resident.
     */
    public function destroy(Resident $resident)
    {
        $resident->delete();

        // Log the activity
        activity()
            ->causedBy(auth('admin')->user())
            ->log('deleted resident account');

        return redirect()->route('admin.residents.index')
            ->with('success', 'Resident deleted successfully.');
    }
}