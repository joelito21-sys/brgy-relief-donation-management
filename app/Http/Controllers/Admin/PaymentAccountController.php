<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class PaymentAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display GCash donations.
     */
    public function gcash(Request $request)
    {
        $donations = Donation::where('type', 'cash')
            ->where('payment_method', 'gcash')
            ->with(['donor', 'approvedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalAmount = Donation::where('type', 'cash')
            ->where('payment_method', 'gcash')
            ->sum('amount');

        $pendingCount = Donation::where('type', 'cash')
            ->where('payment_method', 'gcash')
            ->where('status', 'pending')
            ->count();

        $approvedCount = Donation::where('type', 'cash')
            ->where('payment_method', 'gcash')
            ->where('status', '!=', 'pending')
            ->count();

        return view('admin.payment-accounts.gcash', compact(
            'donations',
            'totalAmount',
            'pendingCount',
            'approvedCount'
        ));
    }

    /**
     * Display PayMaya donations.
     */
    public function paymaya(Request $request)
    {
        $donations = Donation::where('type', 'cash')
            ->where('payment_method', 'paymaya')
            ->with(['donor', 'approvedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalAmount = Donation::where('type', 'cash')
            ->where('payment_method', 'paymaya')
            ->sum('amount');

        $pendingCount = Donation::where('type', 'cash')
            ->where('payment_method', 'paymaya')
            ->where('status', 'pending')
            ->count();

        $approvedCount = Donation::where('type', 'cash')
            ->where('payment_method', 'paymaya')
            ->where('status', '!=', 'pending')
            ->count();

        return view('admin.payment-accounts.paymaya', compact(
            'donations',
            'totalAmount',
            'pendingCount',
            'approvedCount'
        ));
    }

    /**
     * Display Bank donations.
     */
    public function bank(Request $request)
    {
        $donations = Donation::where('type', 'cash')
            ->where('payment_method', 'bank')
            ->with(['donor', 'approvedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalAmount = Donation::where('type', 'cash')
            ->where('payment_method', 'bank')
            ->sum('amount');

        $pendingCount = Donation::where('type', 'cash')
            ->where('payment_method', 'bank')
            ->where('status', 'pending')
            ->count();

        $approvedCount = Donation::where('type', 'cash')
            ->where('payment_method', 'bank')
            ->where('status', '!=', 'pending')
            ->count();

        return view('admin.payment-accounts.bank', compact(
            'donations',
            'totalAmount',
            'pendingCount',
            'approvedCount'
        ));
    }
}
