<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReliefRequest;
use App\Models\ReliefItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReliefRequestsExport;
use Spatie\Activitylog\Models\Activity;

class ReliefRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ReliefRequest::with(['user', 'resident', 'items', 'approver'])
            ->withCount('items')
            ->latest();

        // Apply filters
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Apply search filter
        if ($request->has('search') && $request->search) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('request_number', 'like', $searchTerm)
                  ->orWhere('status', 'like', $searchTerm)
                  ->orWhere('delivery_method', 'like', $searchTerm)
                  ->orWhereHas('user', function($q) use ($searchTerm) {
                      $q->where('first_name', 'like', $searchTerm)
                        ->orWhere('last_name', 'like', $searchTerm)
                        ->orWhere('email', 'like', $searchTerm);
                  })
                  ->orWhereHas('resident', function($q) use ($searchTerm) {
                      $q->where('first_name', 'like', $searchTerm)
                        ->orWhere('last_name', 'like', $searchTerm)
                        ->orWhere('email', 'like', $searchTerm);
                  });
            });
        }

        // Apply additional filters
        $filters = $request->only(['status', 'delivery_method', 'date_from', 'date_to']);
        foreach ($filters as $key => $value) {
            if ($value) {
                switch ($key) {
                    case 'date_from':
                        $query->whereDate('created_at', '>=', $value);
                        break;
                    case 'date_to':
                        $query->whereDate('created_at', '<=', $value);
                        break;
                    default:
                        $query->where($key, $value);
                }
            }
        }

        // Handle sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $perPage = $request->get('per_page', 15);
        $requests = $query->paginate($perPage)->withQueryString();
        
        // Get all unique statuses for filter dropdown
        $allStatuses = ReliefRequest::select('status')
            ->distinct()
            ->pluck('status')
            ->mapWithKeys(function($status) {
                return [$status => ucfirst(str_replace('_', ' ', $status))];
            });
            
        // Get all delivery methods for filter dropdown
        $deliveryMethods = [
            'pickup' => 'Pickup',
            'delivery' => 'Delivery'
        ];
        $statuses = [
            'pending' => 'Pending',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'ready_for_pickup' => 'Ready for Pickup',
            'claimed' => 'Claimed',
            'delivered' => 'Delivered',
        ];

        // Get users for the create request modal
        $users = \App\Models\User::select('id', 'name')
            ->orderBy('name')
            ->get();
            
        // Get residents for the create request modal
        $residents = \App\Models\Resident::select('id', 'first_name', 'last_name', 'email')
            ->where('approval_status', 'approved') // Only approved residents
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();
            
        // Get active relief items for the request form
        $reliefItems = ReliefItem::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.relief-requests.index', [
            'requests' => $requests,
            'statuses' => $statuses,
            'users' => $users,
            'residents' => $residents,
            'reliefItems' => $reliefItems,
            'allStatuses' => $allStatuses,
            'deliveryMethods' => $deliveryMethods,
            'filters' => $filters,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('type', 'user')->orderBy('name')->get();
        $reliefItems = ReliefItem::where('is_active', true)->orderBy('name')->get();
        
        return view('admin.relief-requests.create', compact('users', 'reliefItems'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'reason' => 'nullable|string|max:1000',
            'family_members' => 'required|integer|min:1|max:20',
            'delivery_method' => 'required|in:pickup,delivery',
            'pickup_location' => 'required_if:delivery_method,pickup|string|max:255',
            'delivery_address' => 'required_if:delivery_method,delivery|string|max:1000',
            'scheduled_pickup_date' => 'nullable|date|after_or_equal:today',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:relief_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.notes' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            // Create the relief request
            $reliefRequest = ReliefRequest::create([
                'user_id' => $validated['user_id'],
                'reason' => $validated['reason'] ?? null,
                'family_members' => $validated['family_members'],
                'delivery_method' => $validated['delivery_method'],
                'pickup_location' => $validated['pickup_location'] ?? null,
                'delivery_address' => $validated['delivery_address'] ?? null,
                'scheduled_pickup_date' => $validated['scheduled_pickup_date'] ?? null,
                'status' => 'approved', // Auto-approve admin-created requests
                'approved_by' => auth('admin')->id(),
                'approved_at' => now(),
            ]);

            // Attach items to the request
            foreach ($validated['items'] as $item) {
                $reliefItem = ReliefItem::findOrFail($item['id']);
                
                // Check if there's enough quantity available
                if ($reliefItem->quantity_available < $item['quantity']) {
                    throw new \Exception("Not enough quantity available for {$reliefItem->name}");
                }

                // Attach item to request
                $reliefRequest->items()->attach($item['id'], [
                    'quantity' => $item['quantity'],
                    'notes' => $item['notes'] ?? null,
                ]);

                // Update the available quantity
                $reliefItem->decrement('quantity_available', $item['quantity']);
                $reliefItem->increment('quantity_reserved', $item['quantity']);
            }

            // Generate QR code
            $this->generateQrCode($reliefRequest);

            DB::commit();

            return redirect()->route('admin.relief-requests.show', $reliefRequest)
                ->with('success', 'Relief request created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create relief request: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ReliefRequest $reliefRequest)
    {
        $reliefRequest->load(['resident', 'items', 'approver']);
        return view('admin.relief-requests.show', compact('reliefRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReliefRequest $reliefRequest)
    {
        if (!$reliefRequest->isPending()) {
            return redirect()->route('admin.relief-requests.show', $reliefRequest)
                ->with('warning', 'Only pending requests can be edited.');
        }

        $reliefRequest->load('items');
        $reliefItems = ReliefItem::where('is_active', true)->orderBy('name')->get();
        
        return view('admin.relief-requests.edit', compact('reliefRequest', 'reliefItems'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReliefRequest $reliefRequest)
    {
        if (!$reliefRequest->isPending()) {
            return redirect()->route('admin.relief-requests.show', $reliefRequest)
                ->with('error', 'Only pending requests can be updated.');
        }

        $validated = $request->validate([
            'reason' => 'nullable|string|max:1000',
            'family_members' => 'required|integer|min:1|max:20',
            'delivery_method' => 'required|in:pickup,delivery',
            'pickup_location' => 'required_if:delivery_method,pickup|string|max:255',
            'delivery_address' => 'required_if:delivery_method,delivery|string|max:1000',
            'scheduled_pickup_date' => 'nullable|date|after_or_equal:today',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:relief_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.notes' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            // Update the relief request
            $reliefRequest->update([
                'reason' => $validated['reason'] ?? null,
                'family_members' => $validated['family_members'],
                'delivery_method' => $validated['delivery_method'],
                'pickup_location' => $validated['pickup_location'] ?? null,
                'delivery_address' => $validated['delivery_address'] ?? null,
                'scheduled_pickup_date' => $validated['scheduled_pickup_date'] ?? null,
            ]);

            // Sync items
            $itemsToAttach = [];
            $itemQuantities = [];

            foreach ($validated['items'] as $item) {
                $itemsToAttach[$item['id']] = [
                    'quantity' => $item['quantity'],
                    'notes' => $item['notes'] ?? null,
                ];
                $itemQuantities[$item['id']] = $item['quantity'];
            }

            // Get the current items to calculate quantity differences
            $currentItems = $reliefRequest->items->keyBy('id');
            
            // Attach/update items
            $reliefRequest->items()->sync($itemsToAttach);

            // Update item quantities
            foreach ($itemQuantities as $itemId => $quantity) {
                $item = ReliefItem::findOrFail($itemId);
                $currentQuantity = $currentItems->has($itemId) 
                    ? $currentItems[$itemId]->pivot->quantity 
                    : 0;
                
                $quantityDiff = $quantity - $currentQuantity;
                
                if ($quantityDiff > 0) {
                    // Decrease available quantity
                    if ($item->quantity_available < $quantityDiff) {
                        throw new \Exception("Not enough quantity available for {$item->name}");
                    }
                    $item->decrement('quantity_available', $quantityDiff);
                    $item->increment('quantity_reserved', $quantityDiff);
                } elseif ($quantityDiff < 0) {
                    // Increase available quantity
                    $item->increment('quantity_available', abs($quantityDiff));
                    $item->decrement('quantity_reserved', abs($quantityDiff));
                }
            }

            // For items that were removed, return the quantities
            $removedItems = $currentItems->diffKeys(collect($itemsToAttach));
            foreach ($removedItems as $item) {
                $quantity = $item->pivot->quantity;
                $item->increment('quantity_available', $quantity);
                $item->decrement('quantity_reserved', $quantity);
            }

            DB::commit();

            return redirect()->route('admin.relief-requests.show', $reliefRequest)
                ->with('success', 'Relief request updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to update relief request: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReliefRequest $reliefRequest)
    {
        if (!$reliefRequest->isPending()) {
            return redirect()->route('admin.relief-requests.show', $reliefRequest)
                ->with('error', 'Only pending requests can be deleted.');
        }

        try {
            DB::beginTransaction();

            // Return quantities to available stock
            foreach ($reliefRequest->items as $item) {
                $item->increment('quantity_available', $item->pivot->quantity);
                $item->decrement('quantity_reserved', $item->pivot->quantity);
            }

            // Delete the request
            $reliefRequest->delete();

            DB::commit();

            return redirect()->route('admin.relief-requests.index')
                ->with('success', 'Relief request deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete relief request: ' . $e->getMessage());
        }
    }

    /**
     * Approve the specified relief request.
     */
    public function approve(Request $request, ReliefRequest $reliefRequest)
    {
        if (!$reliefRequest->isPending()) {
            return back()->with('error', 'Only pending requests can be approved.');
        }

        try {
            DB::beginTransaction();

            // Check if there's enough quantity available for all items
            foreach ($reliefRequest->items as $item) {
                if ($item->quantity_available < $item->pivot->quantity) {
                    throw new \Exception("Not enough quantity available for {$item->name}");
                }
            }

            // Update quantities and approve the request
            foreach ($reliefRequest->items as $item) {
                $item->decrement('quantity_available', $item->pivot->quantity);
                $item->increment('quantity_reserved', $item->pivot->quantity);
            }

            $reliefRequest->approve(auth('admin')->id());
            
            // Generate QR code if not exists
            if (!$reliefRequest->qr_code_path) {
                $this->generateQrCode($reliefRequest);
            }

            DB::commit();

            // TODO: Send notification to user

            return back()->with('success', 'Relief request approved successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to approve relief request: ' . $e->getMessage());
        }
    }

    /**
     * Reject the specified relief request.
     */
    public function reject(Request $request, ReliefRequest $reliefRequest)
    {
        if (!$reliefRequest->isPending()) {
            return back()->with('error', 'Only pending requests can be rejected.');
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        try {
            $reliefRequest->reject($validated['rejection_reason']);
            
            // TODO: Send notification to user

            return back()->with('success', 'Relief request rejected successfully.');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to reject relief request: ' . $e->getMessage());
        }
    }

    /**
     * Mark the specified relief request as ready for pickup.
     */
    public function markAsReady(ReliefRequest $reliefRequest)
    {
        if (!$reliefRequest->isApproved()) {
            return back()->with('error', 'Only approved requests can be marked as ready for pickup.');
        }

        try {
            $reliefRequest->markAsReadyForPickup();
            
            // TODO: Send notification to user

            return back()->with('success', 'Relief request marked as ready for pickup.');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update relief request: ' . $e->getMessage());
        }
    }

    /**
     * Mark the specified relief request as claimed.
     */
    public function markAsClaimed(ReliefRequest $reliefRequest)
    {
        if (!$reliefRequest->isReadyForPickup()) {
            return back()->with('error', 'Only requests marked as ready for pickup can be claimed.');
        }

        try {
            $reliefRequest->markAsClaimed();
            
            // Update reserved quantities to distributed
            foreach ($reliefRequest->items as $item) {
                $item->decrement('quantity_reserved', $item->pivot->quantity);
            }

            return back()->with('success', 'Relief request marked as claimed.');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update relief request: ' . $e->getMessage());
        }
    }

    /**
     * Generate a QR code for the relief request.
     */
    protected function generateQrCode(ReliefRequest $reliefRequest)
    {
        $url = route('admin.relief-requests.verify', $reliefRequest->claim_code);
        
        // Generate QR code using chillerlan package with Imagick
        $options = new QROptions([
            'version' => 5,
            'outputType' => QRCode::OUTPUT_IMAGICK,
            'imageBase64' => false,
            'eccLevel' => QRCode::ECC_L,
            'imagickFormat' => 'png',
        ]);
        
        $qrCode = (new QRCode($options))->render($url);
        
        // The render method returns image data directly when using OUTPUT_IMAGICK
        // Save QR code to storage
        $path = 'qrcodes/relief-requests/' . $reliefRequest->id . '.png';
        Storage::disk('public')->put($path, $qrCode);
        
        // Update the request with QR code path
        $reliefRequest->update(['qr_code_path' => $path]);
        
        return $path;
    }

    /**
     * Generate a PDF for the relief request.
     */
    public function pdf(ReliefRequest $reliefRequest)
    {
        $reliefRequest->load(['user', 'items', 'approver']);
        
        $pdf = PDF::loadView('admin.relief-requests.pdf', compact('reliefRequest'));
        
        return $pdf->download('relief-request-' . $reliefRequest->request_number . '.pdf');
    }
    
    /**
     * Verify a relief request by QR code.
     */
    public function verify($claimCode)
    {
        $reliefRequest = ReliefRequest::where('claim_code', $claimCode)->firstOrFail();
        
        return view('admin.relief-requests.verify', compact('reliefRequest'));
    }

    /**
     * Bulk update status of multiple relief requests.
     */
    public function bulkUpdate(Request $request)
    {
        $validated = $request->validate([
            'request_ids' => 'required|array',
            'request_ids.*' => 'exists:relief_requests,id',
            'action' => 'required|in:approve,reject,mark_ready,mark_claimed,mark_delivered,delete',
            'rejection_reason' => 'required_if:action,reject|string|max:1000|nullable',
        ]);

        $count = 0;
        $failed = 0;
        
        try {
            DB::beginTransaction();
            
            foreach ($validated['request_ids'] as $id) {
                $reliefRequest = ReliefRequest::findOrFail($id);
                
                try {
                    switch ($validated['action']) {
                        case 'approve':
                            if ($reliefRequest->isPending()) {
                                $reliefRequest->approve(auth('admin')->id());
                                $count++;
                            } else {
                                $failed++;
                            }
                            break;
                            
                        case 'reject':
                            if ($reliefRequest->isPending()) {
                                $reliefRequest->reject($validated['rejection_reason']);
                                $count++;
                            } else {
                                $failed++;
                            }
                            break;
                            
                        case 'mark_ready':
                            if ($reliefRequest->isApproved()) {
                                $reliefRequest->markAsReadyForPickup();
                                $count++;
                            } else {
                                $failed++;
                            }
                            break;
                            
                        case 'mark_claimed':
                            if ($reliefRequest->isReadyForPickup()) {
                                $reliefRequest->markAsClaimed();
                                $count++;
                            } else {
                                $failed++;
                            }
                            break;
                            
                        case 'mark_delivered':
                            if ($reliefRequest->isClaimed()) {
                                $reliefRequest->markAsDelivered();
                                $count++;
                            } else {
                                $failed++;
                            }
                            break;
                            
                        case 'delete':
                            if ($reliefRequest->isPending()) {
                                $reliefRequest->delete();
                                $count++;
                            } else {
                                $failed++;
                            }
                            break;
                    }
                    
                    // Log the bulk action
                    activity('relief_request')
                        ->performedOn($reliefRequest)
                        ->withProperties([
                            'action' => $validated['action'],
                            'by' => auth('admin')->user()->name,
                            'ip' => $request->ip(),
                            'user_agent' => $request->userAgent()
                        ])
                        ->log('Bulk action: ' . $validated['action']);
                        
                } catch (\Exception $e) {
                    Log::error("Bulk action failed for relief request {$id}: " . $e->getMessage());
                    $failed++;
                    continue;
                }
            }
            
            DB::commit();
            
            $message = "Successfully processed {$count} " . str_plural('request', $count);
            if ($failed > 0) {
                $message .= ". Failed to process {$failed} " . str_plural('request', $failed) . " (invalid status or other error)";
            }
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'count' => $count,
                'failed' => $failed
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Bulk update failed: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to process bulk update: ' . $e->getMessage(),
                'count' => 0,
                'failed' => count($validated['request_ids'])
            ], 500);
        }
    }
    
    /**
     * Export relief requests to Excel/CSV.
     */
    public function export(Request $request)
    {
        $validated = $request->validate([
            'format' => 'required|in:csv,xlsx',
            'columns' => 'required|array',
            'filters' => 'nullable|array'
        ]);
        
        // Apply the same filters as the index method
        $query = $this->getFilteredQuery($request);
        
        // Get the selected columns
        $selectedColumns = $validated['columns'];
        
        // Generate a filename with timestamp
        $filename = 'relief-requests-' . now()->format('Y-m-d-H-i-s') . '.' . $validated['format'];
        
        // Export using Laravel Excel
        return Excel::download(new ReliefRequestsExport($query, $selectedColumns), $filename);
    }
    
    /**
     * Get filtered query based on request parameters.
     */
    protected function getFilteredQuery(Request $request)
    {
        $query = ReliefRequest::with(['user', 'items', 'approver']);
        
        // Apply search filter
        if ($request->has('search') && $request->search) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('request_number', 'like', $searchTerm)
                  ->orWhere('status', 'like', $searchTerm)
                  ->orWhere('delivery_method', 'like', $searchTerm)
                  ->orWhereHas('user', function($q) use ($searchTerm) {
                      $q->where('first_name', 'like', $searchTerm)
                        ->orWhere('last_name', 'like', $searchTerm)
                        ->orWhere('email', 'like', $searchTerm);
                  });
            });
        }
        
        // Apply filters
        $filters = $request->only(['status', 'delivery_method', 'date_from', 'date_to']);
        foreach ($filters as $key => $value) {
            if ($value) {
                switch ($key) {
                    case 'date_from':
                        $query->whereDate('created_at', '>=', $value);
                        break;
                    case 'date_to':
                        $query->whereDate('created_at', '<=', $value);
                        break;
                    default:
                        $query->where($key, $value);
                }
            }
        }
        
        // Apply sorting
        if ($request->has('sort') && $request->sort) {
            $direction = $request->direction ?? 'asc';
            $query->orderBy($request->sort, $direction);
        } else {
            $query->latest();
        }
        
        return $query;
    }
    
    /**
     * Get activity logs for a relief request.
     */
    public function activityLogs(ReliefRequest $reliefRequest)
    {
        $activities = Activity::forSubject($reliefRequest)
            ->orWhere('subject_type', ReliefRequest::class)
            ->where('subject_id', $reliefRequest->id)
            ->with('causer')
            ->latest()
            ->paginate(15);
            
        return view('admin.relief-requests.activity-logs', [
            'reliefRequest' => $reliefRequest,
            'activities' => $activities
        ]);
    }

    /**
     * Print relief request details.
     */
    public function print(ReliefRequest $reliefRequest)
    {
        $reliefRequest->load(['resident', 'items', 'approver']);
        
        return view('admin.relief-requests.print', compact('reliefRequest'));
    }
}
