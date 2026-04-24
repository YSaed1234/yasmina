<?php

namespace Modules\Web\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Web\Services\WebNotificationService;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(WebNotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $vendorId = request()->vendor_id;
        $notifications = $this->notificationService->getNotifications($vendorId);
        
        return view('web::profile.notifications', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $this->notificationService->markAsRead($id);
        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        $vendorId = request()->vendor_id;
        $this->notificationService->markAllAsRead($vendorId);
        return back()->with('success', __('All notifications marked as read.'));
    }
}
