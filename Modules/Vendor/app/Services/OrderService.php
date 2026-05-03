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
 
    public function createManualOrder(int $vendorId, array $data)
    {
        $vendor = \App\Models\Vendor::findOrFail($vendorId);
        $items = $data['items'] ?? [];
        $shippingCost = (float) ($data['shipping_amount'] ?? 0);
        $totalItemsAmount = 0;
        
        foreach ($items as $item) {
            $totalItemsAmount += $item['price'] * $item['quantity'];
        }
 
        $totalCommission = 0;
        $itemCommissions = [];
 
        $hasProductCommission = !empty($vendor->product_commission_type) && !empty($vendor->product_commission_value);
        if ($hasProductCommission) {
            foreach ($items as $index => $item) {
                $itemTotal = $item['price'] * $item['quantity'];
                $itemComm = ($vendor->product_commission_type === 'percentage') 
                    ? ($itemTotal * $vendor->product_commission_value) / 100 
                    : ($vendor->product_commission_value * $item['quantity']);
                
                $totalCommission += $itemComm;
                $itemCommissions[$index] = $itemComm;
            }
        } else {
            if ($vendor->commission_type === 'percentage') {
                $totalCommission = ($totalItemsAmount * ($vendor->commission_value ?? 0)) / 100;
            } else {
                $totalCommission = $vendor->commission_value ?? 0;
            }
 
            if ($totalItemsAmount > 0) {
                foreach ($items as $index => $item) {
                    $itemTotal = $item['price'] * $item['quantity'];
                    $itemCommissions[$index] = ($itemTotal / $totalItemsAmount) * $totalCommission;
                }
            } else {
                foreach ($items as $index => $item) {
                    $itemCommissions[$index] = 0;
                }
            }
        }
 
        $finalTotal = $totalItemsAmount + $shippingCost;
        $vendorNetAmount = ($totalItemsAmount - $totalCommission) + $shippingCost;
 
        return \Illuminate\Support\Facades\DB::transaction(function() use ($data, $vendor, $items, $finalTotal, $shippingCost, $totalCommission, $vendorNetAmount, $itemCommissions) {
            $order = Order::create([
                'vendor_id' => $vendor->id,
                'total' => $finalTotal,
                'shipping_amount' => $shippingCost,
                'commission_amount' => $totalCommission,
                'vendor_net_amount' => $vendorNetAmount,
                'status' => 'new',
                'payment_status' => $data['payment_status'] ?? 'pending',
                'payment_method' => $data['payment_method'] ?? 'manual',
                'source' => $data['source'] ?? 'manual',
                'is_manual' => true,
                'customer_name' => $data['customer_name'],
                'customer_phone' => $data['customer_phone'],
                'shipping_details' => [
                    'name' => $data['customer_name'],
                    'phone' => $data['customer_phone'],
                    'address' => $data['customer_address'],
                    'manual_entry' => true,
                ],
                'notes' => $data['notes'] ?? null,
            ]);
 
            foreach ($items as $index => $item) {
                $productId = $item['product_id'];
                $variantId = $item['variant_id'] ?? null;
                $product = \App\Models\Product::lockForUpdate()->where('vendor_id', $vendor->id)->findOrFail($productId);
                
                if ($variantId) {
                    $variant = \App\Models\ProductVariant::lockForUpdate()->whereHas('product', fn($q) => $q->where('vendor_id', $vendor->id))->findOrFail($variantId);
                    $variant->decrement('stock', $item['quantity']);
                } else {
                    $product->decrement('stock', $item['quantity']);
                }
 
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'variant_id' => $variantId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'commission_amount' => $itemCommissions[$index] ?? 0,
                ]);
            }
 
            return $order;
        });
    }
}
