<?php

namespace Modules\Web\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $vendorId = request()->vendor_id;
        $query = auth()->user()->notifications();

        $query->where('vendor_id', $vendorId);

        $notifications = $query->paginate(15);
        return view('web::profile.notifications', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', __('All notifications marked as read.'));
    }
}
