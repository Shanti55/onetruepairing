<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

    // ── Trash index: View page (purana wala — rakhein as is)
    public function trash()
    {
        $notifications = auth()->user()->notifications()
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->paginate(20);
        return view('admin-panel.notifications.trash', compact('notifications'));
    }

    // ── ✅ Trash DataTable: Combined trash page ke liye JSON response
    public function trashDatatable(Request $request)
    {
        $query = DB::table('notifications')
                    ->where('notifiable_id', auth()->id())
                    ->whereNotNull('deleted_at')
                    ->orderBy('deleted_at', 'desc');

        $total = $query->count();

        // Search filter
        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search) {
                $q->where('data', 'like', "%{$search}%");
            });
        }

        $filtered = $query->count();

        $notifications = $query
            ->offset($request->input('start', 0))
            ->limit($request->input('length', 10))
            ->get();

        $start = $request->input('start', 0);

        $data = $notifications->map(function ($n, $i) use ($start) {
            $payload = json_decode($n->data, true);

            $title   = $payload['title']   ?? $payload['subject'] ?? '—';
            $message = $payload['message'] ?? $payload['body']    ?? '—';

            $deletedAt = Carbon::parse($n->deleted_at)->format('d M Y, h:i A');

            $action = '
                <button class="btn btn-sm btn-outline-success notif-restore-btn"
                        data-id="' . $n->id . '">
                    <i class="bi bi-arrow-counterclockwise me-1"></i>Restore
                </button>
                <button class="btn btn-sm btn-outline-danger notif-force-delete-btn ms-1"
                        data-id="' . $n->id . '">
                    <i class="bi bi-trash3 me-1"></i>Delete Forever
                </button>
            ';

            return [
                'DT_RowIndex' => $start + $i + 1,
                'title'       => e($title),
                'message'     => \Illuminate\Support\Str::limit(e($message), 60),
                'deleted_at'  => $deletedAt,
                'action'      => $action,
            ];
        });

        return response()->json([
            'draw'            => intval($request->input('draw')),
            'recordsTotal'    => $total,
            'recordsFiltered' => $filtered,
            'data'            => $data,
        ]);
    }

    // ── Restore from trash: Single notification wapas layein
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