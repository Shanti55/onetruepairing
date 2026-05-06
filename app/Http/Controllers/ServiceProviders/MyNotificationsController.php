<?php

namespace App\Http\Controllers\ServiceProviders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyNotificationsController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Notifications fetch karna pagination ke saath
        $notifications = $user->notifications()->paginate(15);

        return view('service-provider-panel.notifications.index', [
            'user' => $user,
            'notifications' => $notifications,
            'profile' => $user->serviceproviderprofile() ? $user->serviceproviderprofile()->first() : null
        ]);
    }

    // Single Notification ko Read mark karne ke liye
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return back()->with('success', 'Notification marked as read');
    }

    // Saari Notifications ko ek saath Read mark karne ke liye (Optional but useful)
    public function markAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read');
    }
}