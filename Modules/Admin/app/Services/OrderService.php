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
        $updated = $order->update([
            'status' => $data['status'],
        ]);

        if ($updated && $order->user) {
            $order->user->notify(new \App\Notifications\OrderStatusUpdatedNotification($order));
        }

        return $updated;
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
