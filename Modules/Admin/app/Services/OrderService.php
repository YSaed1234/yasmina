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
        return $order->update([
            'status' => $data['status'],
            'payment_status' => $data['payment_status']
        ]);
    }

    public function delete(Order $order)
    {
        return $order->delete();
    }
}
