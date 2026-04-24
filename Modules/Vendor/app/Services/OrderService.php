<?php

namespace Modules\Vendor\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    /**
     * Get paginated orders that belong to the specified vendor.
     */
    public function getVendorOrders(int $vendorId, int $limit = 10)
    {
        return Order::whereHas('items.product', function ($query) use ($vendorId) {
            $query->where('vendor_id', $vendorId);
        })
        ->with(['items' => function($query) use ($vendorId) {
            $query->whereHas('product', function($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId);
            })->with('product.currency');
        }])
        ->latest()
        ->paginate($limit);
    }

    /**
     * Get order details and ensure it belongs to the vendor.
     */
    public function getOrderDetailsForVendor(Order $order, int $vendorId)
    {
        if (!$this->belongsToVendor($order, $vendorId)) {
            abort(403);
        }

        return $order->load(['items' => function($query) use ($vendorId) {
            $query->whereHas('product', function($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId);
            })->with('product.currency');
        }]);
    }

    /**
     * Update order status.
     */
    public function updateOrderStatus(Order $order, int $vendorId, array $data)
    {
        if (!$this->belongsToVendor($order, $vendorId)) {
            abort(403);
        }

        $status = $data['status'];
        $rejectionReason = $data['rejection_reason'] ?? null;

        $updateData = ['status' => $status];
        if ($status === 'cancelled' && $rejectionReason) {
            $updateData['rejection_reason'] = $rejectionReason;
        }

        $order->update($updateData);

        if ($order->user) {
            if ($status === 'cancelled') {
                $order->user->notify(new \App\Notifications\OrderCancelledNotification($order, $rejectionReason));
            } else {
                $order->user->notify(new \App\Notifications\OrderStatusUpdatedNotification($order));
            }
        }

        return $order;
    }

    /**
     * Update order payment status.
     */
    public function updateOrderPaymentStatus(Order $order, int $vendorId, string $status)
    {
        if (!$this->belongsToVendor($order, $vendorId)) {
            abort(403);
        }

        $order->update(['payment_status' => $status]);

        return $order;
    }

    /**
     * Check if the order has at least one product belonging to the vendor.
     */
    protected function belongsToVendor(Order $order, int $vendorId): bool
    {
        return $order->items()->whereHas('product', fn($q) => $q->where('vendor_id', $vendorId))->exists();
    }
}
