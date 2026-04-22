<?php

namespace Modules\Admin\Services;

use App\Models\Order;

class OrderService
{
    public function getAllPaginated($limit = 10)
    {
        return Order::latest()->paginate($limit);
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
