<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    /**
     * Display a listing of the donations.
     */
    public function index(Request $request)
    {
        // Auto-approve cash donations that are pending (excluding walk-ins)
        Donation::where('type', 'cash')
            ->where('status', 'pending')
            ->where('payment_method', '!=', 'walkin')
            ->update([
                'status' => 'approved',
                'approved_by' => auth('admin')->id(),
                'approved_at' => now(),
            ]);

        // Get statistics for each donation type
        $stats = [
            'cash' => [
                'total' => Donation::where('type', 'cash')->count(),
                'approved' => Donation::where('type', 'cash')->whereIn('status', ['approved', 'completed'])->count(),
                'pending' => Donation::where('type', 'cash')->where('status', 'pending')->count(),
                'total_amount' => Donation::where('type', 'cash')->whereIn('status', ['approved', 'completed'])->sum('amount'),
            ],
            'food' => [
                'total' => Donation::where('type', 'food')->count(),
                'approved' => Donation::where('type', 'food')->where('status', 'approved')->count(),
                'pending' => Donation::where('type', 'food')->where('status', 'pending')->count(),
            ],
            'clothing' => [
                'total' => Donation::where('type', 'clothing')->count(),
                'approved' => Donation::where('type', 'clothing')->where('status', 'approved')->count(),
                'pending' => Donation::where('type', 'clothing')->where('status', 'pending')->count(),
            ],
            'medicine' => [
                'total' => Donation::where('type', 'medicine')->count(),
                'approved' => Donation::where('type', 'medicine')->where('status', 'approved')->count(),
                'pending' => Donation::where('type', 'medicine')->where('status', 'pending')->count(),
            ],
            'walkin' => [
                'total' => Donation::where('payment_method', 'walkin')->count(),
                'approved' => Donation::where('payment_method', 'walkin')->where('status', 'approved')->count(),
                'pending' => Donation::where('payment_method', 'walkin')->where('status', 'pending')->count(),
            ],
        ];

        // Get recent donations for activity feed
        $recentDonations = Donation::with(['donor', 'approvedBy'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.donations.index', compact('stats', 'recentDonations'));
    }

    /**
     * Display walk-in appointments
     */
    public function walkins()
    {
        $appointments = Donation::where('payment_method', 'walkin')
            ->with(['donor'])
            ->latest()
            ->paginate(20);

        return view('admin.donations.walkins', compact('appointments'));
    }

    /**
     * Display donations by type
     */
    public function showByType($type)
    {
        // Validate donation type
        $validTypes = ['cash', 'food', 'clothing', 'medicine'];
        if (!in_array($type, $validTypes)) {
            abort(404);
        }

        $query = Donation::where('type', $type)
            ->with(['donor', 'approvedBy'])
            ->latest();

        $donations = $query->paginate(20);

        // Separate donations by status
        $pendingDonations = $donations->where('status', 'pending');
        $approvedDonations = $donations->where('status', 'approved');
        $rejectedDonations = $donations->where('status', 'rejected');
        $completedDonations = $donations->where('status', 'completed');

        return view('admin.donations.type', compact(
            'type', 
            'donations', 
            'pendingDonations', 
            'approvedDonations', 
            'rejectedDonations',
            'completedDonations'
        ));
    }

    /**
     * Display the specified donation.
     */
    public function show(Donation $donation)
    {
        $donation->load(['donor', 'approvedBy']);
        $photoUrls = $this->getPhotoUrls($donation);
        
        return view('admin.donations.show', compact('donation', 'photoUrls'));
    }

    /**
     * Update the specified donation status.
     */
    public function updateStatus(Request $request, Donation $donation)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected,collected,distributed,completed',
            'notes' => 'nullable|string|max:1000'
        ]);

        $donation->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['notes'] ?? null,
            'approved_by' => auth('admin')->id(),
            'approved_at' => now(),
        ]);

        // Log activity
        activity()
            ->causedBy(auth('admin')->user())
            ->performedOn($donation)
            ->withProperties(['status' => $validated['status']])
            ->log('updated donation status');

        return redirect()->back()->with('success', 'Donation status updated successfully.');
    }

    /**
     * Accept a donation.
     */
    public function accept(Donation $donation)
    {
        $donation->update([
            'status' => 'approved',
            'approved_by' => auth('admin')->id(),
            'approved_at' => now(),
        ]);

        // Log activity
        activity()
            ->causedBy(auth('admin')->user())
            ->performedOn($donation)
            ->withProperties(['action' => 'accepted'])
            ->log('accepted donation');

        return redirect()->back()->with('success', 'Donation accepted successfully.');
    }

    /**
     * Reject a donation.
     */
    public function reject(Request $request, Donation $donation)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:1000'
        ]);

        $donation->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'approved_by' => auth('admin')->id(),
            'approved_at' => now(),
        ]);

        // Log activity
        activity()
            ->causedBy(auth('admin')->user())
            ->performedOn($donation)
            ->withProperties(['action' => 'rejected', 'reason' => $validated['rejection_reason']])
            ->log('rejected donation');

        return redirect()->back()->with('success', 'Donation rejected successfully.');
    }

    /**
     * Remove the specified donation.
     */
    public function destroy(Donation $donation)
    {
        // Delete associated files
        if ($donation->receipt_path) {
            Storage::delete($donation->receipt_path);
        }
        
        if ($donation->photo_paths) {
            foreach (json_decode($donation->photo_paths) as $photo) {
                Storage::delete($photo);
            }
        }

        $donation->delete();

        activity()
            ->causedBy(auth('admin')->user())
            ->performedOn($donation)
            ->log('deleted donation');

        return redirect()->route('admin.donations.index')
            ->with('success', 'Donation deleted successfully.');
    }

    /**
     * Get the URL for the donation's photos.
     */
    protected function getPhotoUrls(Donation $donation)
    {
        if (!$donation->photo_paths) {
            return [];
        }

        return collect(json_decode($donation->photo_paths))->map(function ($path) {
            return Storage::url($path);
        });
    }

    /**
     * Handle bulk update of donations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,delete',
            'ids' => 'required|array',
            'ids.*' => 'exists:donations,id',
        ]);

        $count = 0;
        $action = $request->input('action');
        $ids = $request->input('ids');

        try {
            DB::beginTransaction();

            foreach ($ids as $id) {
                $donation = Donation::findOrFail($id);
                
                switch ($action) {
                    case 'approve':
                        $donation->update([
                            'status' => 'approved',
                            'approved_by' => auth('admin')->id(),
                            'approved_at' => now(),
                        ]);
                        $count++;
                        break;
                        
                    case 'reject':
                        $donation->update([
                            'status' => 'rejected',
                            'approved_by' => auth('admin')->id(),
                            'approved_at' => now(),
                        ]);
                        $count++;
                        break;
                        
                    case 'delete':
                        // Delete associated files
                        if ($donation->receipt_path) {
                            Storage::delete($donation->receipt_path);
                        }
                        if ($donation->photo_paths) {
                            foreach (json_decode($donation->photo_paths) as $photo) {
                                Storage::delete($photo);
                            }
                        }
                        $donation->delete();
                        $count++;
                        break;
                }

                // Log activity
                activity()
                    ->causedBy(auth('admin')->user())
                    ->performedOn($donation)
                    ->withProperties(['action' => $action])
                    ->log("bulk {$action}d donation");
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Successfully {$action}d {$count} " . str_plural('donation', $count),
                'count' => $count
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Bulk update failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get donation statistics for the dashboard.
     */
    public function getStats()
    {
        return [
            'total' => Donation::count(),
            'pending' => Donation::where('status', 'pending')->count(),
            'approved' => Donation::where('status', 'approved')->count(),
            'recent' => Donation::with('donor')
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($donation) {
                    return [
                        'id' => $donation->id,
                        'type' => $donation->type,
                        'status' => $donation->status,
                        'amount' => $donation->amount,
                        'donor_name' => $donation->donor_name,
                        'created_at' => $donation->created_at->toDateTimeString(),
                        'donor' => $donation->donor
                    ];
                }),
            'by_type' => Donation::selectRaw('type, count(*) as count')
                ->groupBy('type')
                ->get()
                ->pluck('count', 'type'),
            'by_status' => Donation::selectRaw('status, count(*) as count')
                ->groupBy('status')
                ->get()
                ->pluck('count', 'status'),
        ];
    }
}
