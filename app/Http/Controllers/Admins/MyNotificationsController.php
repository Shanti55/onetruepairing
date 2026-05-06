<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // DB use karne ke liye zaruri hai

class MyNotificationsController extends Controller
{
    // ── Index: Sirf wo notifications jo trash mein nahi hain
    public function index()
    {
        $notifications = auth()->user()->notifications()
            ->whereNull('deleted_at')
            ->latest()
            ->paginate(20);
        return view('admin-panel.notifications.index', compact('notifications'));
    }

    // ── Mark single as read
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();
        if ($notification) $notification->markAsRead();
        return response()->json(['status' => 'ok']);
    }

    // ── Mark all as read
    public function markAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['status' => 'ok']);
    }

    // ── Restore All: Trash se sab wapas layein
    public function restoreAll()
    {
        DB::table('notifications')
            ->where('notifiable_id', auth()->id())
            ->whereNotNull('deleted_at')
            ->update(['deleted_at' => null]);

        return response()->json(['status' => 'ok', 'message' => 'All restored.']);
    }

    // ── Soft delete: Trash mein bhejo
    public function delete($id)
    {
        DB::table('notifications')
            ->where('id', $id)
            ->update(['deleted_at' => now()]);

        return response()->json(['status' => 'ok', 'message' => 'Moved to trash.']);
    }

    // ── Delete all read: Sirf read wali trash mein jayengi
    public function deleteAllRead()
    {
        auth()->user()->readNotifications()
            ->whereNull('deleted_at')
            ->update(['deleted_at' => now()]);

        return response()->json(['status' => 'ok', 'message' => 'All read notifications moved to trash.']);
    }

    // ── Trash index: Sirf trash wali notifications dikhayein
    public function trash()
    {
        $notifications = auth()->user()->notifications()
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->paginate(20);
        return view('admin-panel.notifications.trash', compact('notifications'));
    }

    // ── Restore from trash: Single notification wapas layein
    // NOTE: Isse sirf EK BAAR hi rakhein file mein
    public function restore($id)
    {
        DB::table('notifications')
            ->where('id', $id)
            ->update(['deleted_at' => null]);

        return response()->json(['status' => 'ok', 'message' => 'Notification restored.']);
    }

    // ── Permanently delete: Database se hamesha ke liye khatam
    public function forceDelete($id)
    {
        DB::table('notifications')
            ->where('id', $id)
            ->delete();

        return response()->json(['status' => 'ok', 'message' => 'Permanently deleted.']);
    }
}