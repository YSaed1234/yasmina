<?php

namespace Modules\Web\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\Region;
use App\Models\Coupon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Notifications\NewOrderNotification;

class CheckoutService
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function getCheckoutData($vendor)
    {
        $cartData = $this->cartService->getCartData($vendor->id ?? null);

        if (empty($cartData['cart'])) {
            return ['error' => __('Your cart is empty!')];
        }

        $addresses = Address::with(['governorate', 'region'])
            ->where('user_id', auth()->id())
            ->where('vendor_id', $vendor->id ?? null)
            ->get();

        return array_merge($cartData, ['addresses' => $addresses]);
    }

    public function placeOrder(array $data, $vendor)
    {
        $address = Address::with(['governorate', 'region'])->findOrFail($data['address_id']);

        $region = null;
        if ($vendor) {
            $region = Region::where('vendor_id', $vendor->id)
                ->where('governorate_id', $address->governorate_id)
                ->where('name', $address->region->name)
                ->where('is_active', true)
                ->first();
        }

        if (!$region) {
            $region = $address->region;
        }

        if (!$region || !$region->is_active) {
            return ['success' => false, 'error' => __('Shipping is not available for the selected address / area.')];
        }

        $cartData = $this->cartService->getCartData($vendor->id ?? null);

        if (empty($cartData['cart'])) {
            return ['success' => false, 'error' => __('Your cart is empty!')];
        }

        $shippingCost = $region->rate;

        // Apply Free Shipping if vendor allows it
        if ($vendor && in_array($vendor->id, $cartData['freeShippingVendors'])) {
            $shippingCost = 0;
        }

        $finalTotal = $cartData['finalTotal'] + $shippingCost;

        $commissionAmount = 0;
        if ($vendor->commission_type === 'percentage') {
            $commissionAmount = ($cartData['finalTotal'] * ($vendor->commission_value ?? 0)) / 100;
        } else {
            $commissionAmount = $vendor->commission_value ?? 0;
        }

        $vendorNetAmount = ($cartData['finalTotal'] - $commissionAmount) + $shippingCost;

        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id' => auth()->id(),
                'vendor_id' => $vendor->id,
                'total' => $finalTotal,
                'shipping_amount' => $shippingCost,
                'commission_amount' => $commissionAmount,
                'vendor_net_amount' => $vendorNetAmount,
                'status' => 'new',
                'payment_status' => 'pending',
                'payment_method' => $data['payment_method'],
                'shipping_details' => [
                    'name' => $address->name,
                    'email' => auth()->user()->email,
                    'phone' => $address->phone,
                    'address' => $address->address_line1 . ($address->address_line2 ? ', ' . $address->address_line2 : ''),
                    'city' => $address->city,
                    'country' => $address->country,
                    'shipping_zone' => $address->shippingZone ? $address->shippingZone->name : null
                ],
                'notes' => $data['notes'] ?? null,
                'coupon_id' => $cartData['coupon'] ? $cartData['coupon']->id : null,
                'discount_amount' => $cartData['discount'],
                'vendor_discount_amount' => $cartData['vendorDiscount'],
                'vendor_discount_type' => count($cartData['appliedVendorDiscounts']) > 0 ? $cartData['appliedVendorDiscounts'][0]['type'] : null,
                'promotional_discount_amount' => $cartData['promotionalDiscount'],
            ]);

            foreach ($cartData['cart'] as $key => $details) {
                $productId = $details['product_id'];
                $variantId = $details['variant_id'] ?? null;

                $product = \App\Models\Product::lockForUpdate()->find($productId);
                $variant = $variantId ? \App\Models\ProductVariant::lockForUpdate()->find($variantId) : null;

                if (!$product) {
                    throw new \Exception(__('Product no longer exists.'));
                }

                // Stock Validation
                if ($variant) {
                    if ($variant->stock < $details['quantity']) {
                        throw new \Exception(__('Insufficient stock for :product (:color :size)', [
                            'product' => $product->name,
                            'color' => $variant->color,
                            'size' => $variant->size
                        ]));
                    }
                } else {
                    if (!$product->hasStock($details['quantity'])) {
                        throw new \Exception(__('Insufficient stock for :product', ['product' => $product->name]));
                    }
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'variant_id' => $variantId,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                    'is_gift' => $details['is_gift'] ?? false,
                ]);

                // Decrement stock
                if ($variant) {
                    $variant->decrement('stock', $details['quantity']);
                } else {
                    $product->decrement('stock', $details['quantity']);
                }
            }

            if ($cartData['coupon']) {
                $cartData['coupon']->increment('used_count');
                if (auth()->check()) {
                    $userUsage = $cartData['coupon']->users()->where('user_id', auth()->id())->first();
                    if ($userUsage) {
                        $cartData['coupon']->users()->updateExistingPivot(auth()->id(), [
                            'usage_count' => $userUsage->pivot->usage_count + 1
                        ]);
                    } else {
                        $cartData['coupon']->users()->attach(auth()->id(), ['usage_count' => 1]);
                    }
                }
            }

            DB::commit();

            // Send Notification to user
            auth()->user()->notify(new NewOrderNotification($order));

            $this->cartService->clearCart($vendor->id ?? null);

            return ['success' => true, 'order' => $order];

        } catch (\Exception $e) {
            DB::rollBack();
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
