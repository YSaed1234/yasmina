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
    public function updatePaymentStatus(Order $order, int $vendorId, string $status)
    {
        if (!$this->belongsToVendor($order, $vendorId)) {
            abort(403);
        }

        $oldStatus = $order->payment_status;
        $order->payment_status = $status;

        if ($status === 'paid' && $oldStatus !== 'paid') {
            $remaining = $order->total - $order->paid_amount;
            if ($remaining > 0) {
                $order->payments()->create([
                    'amount' => $remaining,
                    'note' => __('Automatic payment record upon status change to paid'),
                ]);
                $order->paid_amount = $order->total;
            }
        }

        $order->save();
        return $order;
    }

    /**
     * Check if the order has at least one product belonging to the vendor.
     */
    protected function belongsToVendor(Order $order, int $vendorId): bool
    {
        return $order->items()->whereHas('product', fn($q) => $q->where('vendor_id', $vendorId))->exists();
    }

    public function recordPayment(Order $order, int $vendorId, array $data)
    {
        if (!$this->belongsToVendor($order, $vendorId)) {
            abort(403);
        }

        $amount = (float) $data['amount'];
        $receiptImage = null;

        if (isset($data['receipt_image']) && $data['receipt_image'] instanceof \Illuminate\Http\UploadedFile) {
            $receiptImage = $data['receipt_image']->store('orders/payments', 'public');
        }

        $order->payments()->create([
            'amount' => $amount,
            'receipt_image' => $receiptImage,
            'note' => $data['note'] ?? null,
            'payment_method' => $data['payment_method'] ?? $order->payment_method,
        ]);

        $newPaidAmount = $order->paid_amount + $amount;
        $order->paid_amount = $newPaidAmount;

        if ($newPaidAmount >= $order->total) {
            $order->payment_status = 'paid';
        } else if ($newPaidAmount > 0) {
            $order->payment_status = 'partially_paid';
        }

        $order->save();

        return $order;
    }

    public function deletePayment(Order $order, int $vendorId, $paymentId)
    {
        if (!$this->belongsToVendor($order, $vendorId)) {
            abort(403);
        }

        if ($order->status->value === 'delivered') {
            throw new \Exception(__('Cannot delete payment for delivered orders.'));
        }

        $payment = $order->payments()->findOrFail($paymentId);
        $amount = $payment->amount;

        if ($payment->receipt_image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($payment->receipt_image);
        }

        $payment->delete();

        $order->paid_amount -= $amount;
        
        if ($order->paid_amount <= 0) {
            $order->payment_status = 'pending';
        } else if ($order->paid_amount < $order->total) {
            $order->payment_status = 'partially_paid';
        } else {
            $order->payment_status = 'paid';
        }

        $order->save();

        return $order;
    }
}
