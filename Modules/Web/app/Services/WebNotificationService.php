<?php

namespace Modules\Web\Services;

class WebNotificationService
{
    public function getNotifications($vendorId, int $perPage = 15)
    {
        return auth()->user()->vendorNotifications($vendorId)->paginate($perPage);
    }

    public function markAsRead(string $id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return true;
    }

    public function markAllAsRead($vendorId = null)
    {
        auth()->user()->vendorUnreadNotifications($vendorId)->update(['read_at' => now()]);
        return true;
    }
}
