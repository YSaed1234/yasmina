<?php

namespace Modules\Admin\Services;

use App\Models\Order;

class OrderService
{
    public function getAllPaginated($limit = 10, array $filters = [])
    {
        $query = Order::with(['user', 'items.product.vendor', 'items.product.currency'])->latest();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['product_id'])) {
            $query->whereHas('items', function($q) use ($filters) {
                $q->where('product_id', $filters['product_id']);
            });
        }

        if (auth()->user()->vendor_id) {
            $query->where('vendor_id', auth()->user()->vendor_id);
        } elseif (!empty($filters['vendor_id'])) {
            $query->where('vendor_id', $filters['vendor_id']);
        }

        return $query->paginate($limit);
    }

    public function getOrderDetails(Order $order)
    {
        return $order->load(['items.product.vendor', 'items.product.currency', 'user']);
    }

    public function updateStatus(Order $order, array $data)
    {
        $oldStatus = $order->status->value ?? $order->status;
        $newStatus = $data['status'];
        $rejectionReason = $data['rejection_reason'] ?? null;

        $updateData = ['status' => $newStatus];
        if ($newStatus === 'cancelled' && $rejectionReason) {
            $updateData['rejection_reason'] = $rejectionReason;
        }

        $updated = $order->update($updateData);

        if ($updated && $order->user) {
            if ($newStatus === 'cancelled') {
                $order->user->notify(new \App\Notifications\OrderCancelledNotification($order, $rejectionReason));
            } else {
                $order->user->notify(new \App\Notifications\OrderStatusUpdatedNotification($order));
            }
            
            // Grant points logic
            $earningStatusSetting = \App\Models\PointSetting::getValue('points_earning_status', 'delivered');
            if ($newStatus === $earningStatusSetting && $oldStatus !== $earningStatusSetting) {
                $this->grantPointsForOrder($order);
            }
        }

        return $updated;
    }

    protected function grantPointsForOrder(Order $order)
    {
        // Check if already granted points for this order to avoid duplicates
        $exists = $order->user->pointTransactions()
            ->where('reference_type', Order::class)
            ->where('reference_id', $order->id)
            ->where('type', 'earning')
            ->exists();
            
        if ($exists) return;

        $pointsPerCurrency = (float) \App\Models\PointSetting::getValue('points_per_currency', 1);
        $points = (int) ($order->total * $pointsPerCurrency);

        if ($points > 0) {
            $order->user->addPoints(
                $points, 
                'earning', 
                __('Points earned from order #:id', ['id' => $order->id]),
                $order
            );
        }
    }

    public function updatePaymentStatus(Order $order, string $status)
    {
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

        if ($order->user) {
            $order->user->notify(new \App\Notifications\PaymentStatusUpdatedNotification($order));
        }

        return $order;
    }

    public function delete(Order $order)
    {
        return $order->delete();
    }

    public function recordPayment(Order $order, array $data)
    {
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

    public function deletePayment(Order $order, $paymentId)
    {
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
