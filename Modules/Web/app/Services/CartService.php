<?php

namespace Modules\Web\Services;

use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getCartData()
    {
        $cart = Session::get('cart', []);
        $total = 0;
        $totalOriginal = 0;
        $totalItemsCount = 0;
        
        $productIds = array_keys($cart);
        $products = Product::with('vendor')->whereIn('id', $productIds)->get()->keyBy('id');

        $vendorGroups = [];

        foreach ($cart as $id => &$item) {
            if (isset($products[$id])) {
                $product = $products[$id];
                $item['price'] = $product->is_gift ? 0 : $product->effective_price;
                $item['original_price'] = $product->price;
                $item['is_flash_sale'] = $product->hasActiveFlashSale();
                $item['vendor_id'] = $product->vendor_id;
                
                $itemTotal = $item['price'] * $item['quantity'];
                $itemTotalOriginal = $item['original_price'] * $item['quantity'];
                
                $total += $itemTotal;
                $totalOriginal += $itemTotalOriginal;
                $totalItemsCount += $item['quantity'];

                // Group by vendor for vendor-level discounts
                if (!isset($vendorGroups[$product->vendor_id])) {
                    $vendorGroups[$product->vendor_id] = [
                        'vendor' => $product->vendor,
                        'total' => 0,
                        'items_count' => 0
                    ];
                }
                $vendorGroups[$product->vendor_id]['total'] += $itemTotal;
                $vendorGroups[$product->vendor_id]['items_count'] += $item['quantity'];
            }
        }
        Session::put('cart', $cart);

        $productSavings = $totalOriginal - $total;

        // Calculate Vendor Level Discounts
        $vendorDiscount = 0;
        $appliedVendorDiscounts = [];

        foreach ($vendorGroups as $vId => $group) {
            $vendor = $group['vendor'];
            if (!$vendor) continue;

            $thresholdDisc = 0;
            // 1. Order Threshold Discount
            if ($vendor->order_threshold && $group['total'] >= $vendor->order_threshold) {
                if ($vendor->order_threshold_discount_type === 'percentage') {
                    $thresholdDisc = ($group['total'] * $vendor->order_threshold_discount) / 100;
                } else {
                    $thresholdDisc = $vendor->order_threshold_discount;
                }
            }

            $multiItemDisc = 0;
            // 2. Multi-item Discount (Bundle)
            if ($vendor->min_items_for_discount && $group['items_count'] >= $vendor->min_items_for_discount) {
                if ($vendor->items_discount_type === 'percentage') {
                    $multiItemDisc = ($group['total'] * $vendor->items_discount_amount) / 100;
                } else {
                    $multiItemDisc = $vendor->items_discount_amount;
                }
            }
            
            // Pick the best discount
            if ($thresholdDisc > 0 || $multiItemDisc > 0) {
                if ($thresholdDisc >= $multiItemDisc) {
                    $vendorDiscount += $thresholdDisc;
                    $appliedVendorDiscounts[] = [
                        'vendor_name' => $vendor->name,
                        'type' => 'threshold',
                        'label' => __('Order Threshold Discount'),
                        'amount' => $thresholdDisc
                    ];
                } else {
                    $vendorDiscount += $multiItemDisc;
                    $appliedVendorDiscounts[] = [
                        'vendor_name' => $vendor->name,
                        'type' => 'multi_item',
                        'label' => __('Multi-item Discount'),
                        'amount' => $multiItemDisc
                    ];
                }
            }
        }

        $coupon = null;
        $discount = 0;
        
        $totalAfterVendorDiscounts = max(0, $total - $vendorDiscount);
        $freeShippingVendors = [];
        foreach ($vendorGroups as $vId => $group) {
            if ($group['vendor']->free_shipping_threshold && $group['total'] >= $group['vendor']->free_shipping_threshold) {
                $freeShippingVendors[] = $vId;
            }
        }

        if (Session::has('coupon')) {
            $couponData = Session::get('coupon');
            $coupon = Coupon::where('code', $couponData['code'])->first();
            
            if ($coupon && $coupon->isValid()) {
                if ($totalAfterVendorDiscounts >= $coupon->min_order_amount) {
                    if ($coupon->type === 'percentage') {
                        $discount = ($totalAfterVendorDiscounts * $coupon->value) / 100;
                    } else {
                        $discount = $coupon->value;
                    }
                } else {
                    Session::forget('coupon');
                }
            } else {
                Session::forget('coupon');
            }
        }
        
        $finalTotal = max(0, $totalAfterVendorDiscounts - $discount);
        
        return [
            'cart' => $cart,
            'total' => $total,
            'totalOriginal' => $totalOriginal,
            'productSavings' => $productSavings,
            'vendorDiscount' => $vendorDiscount,
            'appliedVendorDiscounts' => $appliedVendorDiscounts,
            'availableGifts' => \App\Models\Product::where('is_gift', true)
                                ->where('gift_threshold', '<=', $total)
                                ->whereNotIn('id', array_keys($cart))
                                ->get(),
            'freeShippingVendors' => $freeShippingVendors,
            'coupon' => $coupon,
            'discount' => $discount,
            'finalTotal' => $finalTotal
        ];
    }

    public function applyCoupon(string $code)
    {
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return ['success' => false, 'error' => __('Invalid coupon code.')];
        }

        if (!$coupon->isValid()) {
            return ['success' => false, 'error' => __('This coupon is no longer valid.')];
        }

        if (auth()->check() && !$coupon->canBeUsedByUser(auth()->user())) {
            return ['success' => false, 'error' => __('You have reached the usage limit for this coupon.')];
        }

        $cartData = $this->getCartData();
        if ($cartData['total'] < $coupon->min_order_amount) {
            return ['success' => false, 'error' => __('Minimum order amount for this coupon is :amount', ['amount' => $coupon->min_order_amount])];
        }

        Session::put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value
        ]);

        return ['success' => true, 'message' => __('Coupon applied successfully!')];
    }

    public function removeCoupon()
    {
        Session::forget('coupon');
        return ['success' => true, 'message' => __('Coupon removed successfully.')];
    }

    public function addToCart(int $productId, int $quantity = 1)
    {
        $product = Product::findOrFail($productId);
        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $price = $product->is_gift ? 0 : $product->effective_price;
            
            $cart[$productId] = [
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $price,
                "original_price" => $product->price,
                "is_gift" => $product->is_gift,
                "is_flash_sale" => $product->hasActiveFlashSale(),
                "image" => $product->image,
                "currency" => $product->currency->symbol ?? '$'
            ];
        }

        Session::put('cart', $cart);
        return ['success' => true, 'message' => __('Product added to cart successfully!')];
    }

    public function updateQuantity(int $productId, int $quantity)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId]["quantity"] = $quantity;
            Session::put('cart', $cart);
            return ['success' => true, 'message' => __('Cart updated successfully')];
        }
        return ['success' => false];
    }

    public function removeItem(int $productId)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
            return ['success' => true, 'message' => __('Product removed successfully')];
        }
        return ['success' => false];
    }
}
