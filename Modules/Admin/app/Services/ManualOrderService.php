<?php

namespace Modules\Admin\Services;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class ManualOrderService
{
    public function create(array $data)
    {
        $vendor = \App\Models\Vendor::findOrFail($data['vendor_id']);
        $items = $data['items'] ?? [];
        $shippingCost = (float) ($data['shipping_amount'] ?? 0);
        $totalItemsAmount = 0;
        
        foreach ($items as $item) {
            $totalItemsAmount += $item['price'] * $item['quantity'];
        }

        $totalCommission = 0;
        $itemCommissions = [];

        // Commission Logic
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

        return DB::transaction(function() use ($data, $vendor, $items, $finalTotal, $shippingCost, $totalCommission, $vendorNetAmount, $itemCommissions) {
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
                $product = \App\Models\Product::lockForUpdate()->findOrFail($productId);
                
                if ($variantId) {
                    $variant = \App\Models\ProductVariant::lockForUpdate()->findOrFail($variantId);
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
