<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())->latest()->paginate(20);
        $unreadCount = Notification::where('user_id', Auth::id())->unread()->count();
        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
        $notification->update(['is_read' => true]);
        return back();
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())->unread()->update(['is_read' => true]);
        return back()->with('success', 'Semua notifikasi telah dibaca.');
    }
}
