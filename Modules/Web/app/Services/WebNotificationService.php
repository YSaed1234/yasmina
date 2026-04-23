<?php

namespace Modules\Web\Services;

class WebNotificationService
{
    public function getNotifications($vendorId, int $perPage = 15)
    {
        $query = auth()->user()->notifications();

        if ($vendorId) {
            if (!is_numeric($vendorId)) {
                $vendor = \App\Models\Vendor::where('slug', $vendorId)->first();
                $vendorId = $vendor ? $vendor->id : null;
            }

            if ($vendorId) {
                $query->where('vendor_id', $vendorId);
            }
        }

        return $query->paginate($perPage);
    }

    public function markAsRead(string $id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return true;
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return true;
    }
}
