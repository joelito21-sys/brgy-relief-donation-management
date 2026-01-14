<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the activities.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $activities = ActivityLog::with('causer')
            ->latest()
            ->paginate(15);

        return Inertia::render('Admin/Activities/Index', [
            'activities' => $activities
        ]);
    }
}
