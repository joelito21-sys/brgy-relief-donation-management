<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    /**
     * Display a listing of the notifications.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(20);
        
        return view('admin.notifications.index', [
            'notifications' => $notifications,
            'unreadCount' => Auth::user()->unreadNotifications->count(),
        ]);
    }
    
    /**
     * Mark all notifications as read.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAllAsRead()
    {
        try {
            Auth::user()->unreadNotifications->markAsRead();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    /**
     * Mark a specific notification as read.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->where('id', $id)->first();
        
        if ($notification) {
            $notification->markAsRead();
            
            // If there's a URL in the notification data, redirect there
            if (isset($notification->data['url'])) {
                return redirect($notification->data['url']);
            }
        }
        
        return redirect()->back()->with('success', 'Notification marked as read.');
    }
    
    /**
     * Delete all read notifications.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearRead()
    {
        Auth::user()->readNotifications()->delete();
        return redirect()->route('admin.notifications.index')
            ->with('success', 'Read notifications have been cleared.');
    }
    
    /**
     * Get the count of unread notifications.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function unreadCount()
    {
        $count = Auth::user()->unreadNotifications->count();
        return response()->json(['count' => $count]);
    }
}
