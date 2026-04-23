<?php

namespace Modules\Admin\Services;

use App\Models\Order;

class OrderService
{
    public function getAllPaginated($limit = 10, array $filters = [])
    {
        $query = Order::with('user')->latest();

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

        return $query->paginate($limit);
    }

    public function getOrderDetails(Order $order)
    {
        return $order->load(['items.product', 'user']);
    }

    public function updateStatus(Order $order, array $data)
    {
        $oldStatus = $order->status->value ?? $order->status;
        $newStatus = $data['status'];

        $updated = $order->update([
            'status' => $newStatus,
        ]);

        if ($updated && $order->user) {
            $order->user->notify(new \App\Notifications\OrderStatusUpdatedNotification($order));
            
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
        $updated = $order->update([
            'payment_status' => $status
        ]);

        if ($updated && $order->user) {
            $order->user->notify(new \App\Notifications\PaymentStatusUpdatedNotification($order));
        }

        return $updated;
    }

    public function delete(Order $order)
    {
        return $order->delete();
    }
}
