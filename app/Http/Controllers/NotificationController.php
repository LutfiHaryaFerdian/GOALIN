<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->with('booking.field')
            ->latest()
            ->paginate(20);

        // Add computed fields for frontend
        $notifications->through(function ($n) {
            $n->is_unread         = is_null($n->read_at);
            $n->created_at_human  = $n->created_at->diffForHumans();
            return $n;
        });

        return Inertia::render('Notifications/Index', [
            'notifications' => $notifications->toArray(),
        ]);
    }

    public function markRead(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->markAsRead();

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    public function markAllRead()
    {
        Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return redirect()->back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }
}
