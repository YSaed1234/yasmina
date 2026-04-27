<?php

namespace Modules\Web\Services;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Coupon;

class CartService
{
    private function getCurrentVendorId()
    {
        $vendor = request()->attributes->get('current_vendor');
        return $vendor ? $vendor->id : null;
    }

    private function getSessionKey($vendorId = null)
    {
        $vId = $vendorId ?? $this->getCurrentVendorId();
        return $vId ? "cart_vendor_{$vId}" : "cart_main";
    }

    public function getCartCount($vendorId = null)
    {
        $vId = $vendorId ?? $this->getCurrentVendorId();

        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->where('vendor_id', $vId)->first();
            return $cart ? $cart->items()->count() : 0;
        }

        return count(Session::get($this->getSessionKey($vId), []));
    }

    public function getCartData($vendorId = null)
    {
        $vId = $vendorId ?? $this->getCurrentVendorId();
        $cart = $this->getRawCartItems($vId);

        $total = 0;
        $totalOriginal = 0;
        $totalItemsCount = 0;

        $productIds = array_column($cart, 'product_id');
        $variantIds = array_filter(array_column($cart, 'variant_id'));

        $products = Product::with(['vendor', 'currency'])->whereIn('id', $productIds)->get()->keyBy('id');
        $variants = \App\Models\ProductVariant::whereIn('id', $variantIds)->get()->keyBy('id');

        $vendorGroups = [];

        foreach ($cart as $key => $item) {
            $id = $item['product_id'];
            $vId_variant = $item['variant_id'];

            if (isset($products[$id])) {
                $product = $products[$id];
                $variant = $vId_variant ? ($variants[$vId_variant] ?? null) : null;

                $cart[$key]['name'] = $product->name . ($variant ? " ({$variant->color} {$variant->size})" : "");

                // Final Price with priority logic
                $cart[$key]['price'] = (float) $product->getFinalPrice($variant);

                $cart[$key]['original_price'] = (float) ($variant && $variant->price ? $variant->price : $product->price);
                $cart[$key]['is_flash_sale'] = (bool) $product->hasActiveFlashSale();
                $cart[$key]['vendor_id'] = $product->vendor_id;
                $cart[$key]['image'] = $product->image;
                $cart[$key]['currency'] = $product->currency->symbol ?? '$';
                $cart[$key]['is_gift'] = (bool) $product->is_gift;

                // Force quantity to be integer to prevent Blade errors
                $cart[$key]['quantity'] = (int) $item['quantity'];

                $itemTotal = (float) $cart[$key]['price'] * $cart[$key]['quantity'];
                $itemTotalOriginal = (float) $cart[$key]['original_price'] * $cart[$key]['quantity'];

                // Stock Validation (Check variant stock if exists, otherwise product stock)
                if ($variant) {
                    $cart[$key]['in_stock'] = $variant->stock >= $cart[$key]['quantity'];
                    $cart[$key]['available_stock'] = $variant->stock;
                } else {
                    $cart[$key]['in_stock'] = $product->hasStock($cart[$key]['quantity']);
                    $cart[$key]['available_stock'] = $product->stock;
                }

                $total = (float) $total + $itemTotal;
                $totalOriginal = (float) $totalOriginal + $itemTotalOriginal;
                $totalItemsCount = (int) $totalItemsCount + (int) $cart[$key]['quantity'];

                // Group by vendor
                if (!isset($vendorGroups[$product->vendor_id])) {
                    $vendorGroups[$product->vendor_id] = [
                        'vendor' => $product->vendor,
                        'total' => 0,
                        'items_count' => 0
                    ];
                }
                $vendorGroups[$product->vendor_id]['total'] = (float) $vendorGroups[$product->vendor_id]['total'] + $itemTotal;
                $vendorGroups[$product->vendor_id]['items_count'] = (int) $vendorGroups[$product->vendor_id]['items_count'] + (int) $cart[$key]['quantity'];
            } else {
                // If product no longer exists, remove from cart
                $this->removeItem($key);
                unset($cart[$key]);
            }
        }

        if (!Auth::check()) {
            $rawToSave = [];
            foreach ($cart as $k => $item) {
                $rawToSave[$k] = [
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'],
                    'quantity' => $item['quantity']
                ];
            }
            Session::put($this->getSessionKey($vId), $rawToSave);
        }

        // Calculate BOGO & Cross-sell Promotions
        $promotionalDiscount = 0;
        $appliedPromotions = [];
        $activePromotions = \App\Models\Promotion::where('is_active', true)
            ->whereIn('buy_product_id', $productIds)
            ->where(function ($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            })
            ->get();

        foreach ($activePromotions as $promo) {
            // Find all cart entries for this buy_product_id (sum quantities)
            $buyQtyInCart = 0;
            foreach ($cart as $item) {
                if ($item['product_id'] == $promo->buy_product_id) {
                    $buyQtyInCart = (float) $buyQtyInCart + (int) $item['quantity'];
                }
            }

            if ($buyQtyInCart > 0) {
                if ($promo->type === 'bogo_same') {
                    $cycle = $promo->buy_quantity + $promo->get_quantity;
                    $eligibleQty = floor($buyQtyInCart / $cycle) * $promo->get_quantity;
                } else {
                    $timesApplicable = floor($buyQtyInCart / $promo->buy_quantity);
                    $getQtyInCart = 0;
                    foreach ($cart as $item) {
                        if ($item['product_id'] == $promo->get_product_id) {
                            $getQtyInCart += $item['quantity'];
                        }
                    }
                    $eligibleQty = min($timesApplicable * $promo->get_quantity, $getQtyInCart);
                }

                if ($eligibleQty > 0) {
                    $targetProduct = $products[$promo->get_product_id] ?? null;
                    if ($targetProduct) {
                        $unitPrice = $targetProduct->effective_price;
                        $discountForThisPromo = 0;

                        if ($promo->discount_type === 'free') {
                            $discountForThisPromo = $unitPrice * $eligibleQty;
                        } elseif ($promo->discount_type === 'percentage') {
                            $discountForThisPromo = ($unitPrice * $promo->discount_value / 100) * $eligibleQty;
                        } else {
                            $discountForThisPromo = min($promo->discount_value * $eligibleQty, $unitPrice * $eligibleQty);
                        }

                        $promotionalDiscount += $discountForThisPromo;
                        $appliedPromotions[] = [
                            'name' => $promo->name ?: ($promo->type === 'bogo_same' ? __('BOGO Deal') : __('Bundle Deal')),
                            'amount' => $discountForThisPromo,
                            'details' => $promo->type === 'bogo_same'
                                ? __('Buy :buy get :get free', ['buy' => $promo->buy_quantity, 'get' => $promo->get_quantity])
                                : __('Discount on :product', ['product' => $targetProduct->name])
                        ];
                    }
                }
            }
        }

        $totalAfterPromotions = max(0, $total - $promotionalDiscount);

        $productSavings = $totalOriginal - $total;

        // Calculate Vendor Level Discounts
        $vendorDiscount = 0;
        $appliedVendorDiscounts = [];

        foreach ($vendorGroups as $vId => $group) {
            $vendor = $group['vendor'];
            if (!$vendor)
                continue;

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

        $totalAfterVendorDiscounts = $totalAfterPromotions - $vendorDiscount;

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
        // $finalTotal = max(0, ($totalAfterVendorDiscounts - $discount));
        $finalTotal = ($totalAfterVendorDiscounts - $discount);
        // dd($finalTotal);
        return [
            'cart' => $cart,
            'total' => $total,
            'totalOriginal' => $totalOriginal,
            'productSavings' => $productSavings,
            'promotionalDiscount' => $promotionalDiscount,
            'appliedPromotions' => $appliedPromotions,
            'vendorDiscount' => $vendorDiscount,
            'appliedVendorDiscounts' => $appliedVendorDiscounts,
            'availableGifts' => \App\Models\Product::where('is_gift', true)
                ->where('gift_threshold', '<=', $total)
                ->whereNotIn('id', $productIds)
                ->get(),
            'freeShippingVendors' => $freeShippingVendors,
            'coupon' => $coupon,
            'discount' => $discount,
            'finalTotal' => $finalTotal
        ];
    }

    public function addToCart(int $productId, $variantId = null, int $quantity = 1, $vendorId = null)
    {
        $vId = $vendorId ?? $this->getCurrentVendorId();
        $product = Product::findOrFail($productId);

        // Ensure variant is selected if product has variants
        if ($product->variants()->count() > 0 && !$variantId) {
            return ['success' => false, 'error' => __('Please select your preferred color and size.')];
        }

        $variant = $variantId ? \App\Models\ProductVariant::findOrFail($variantId) : null;

        $key = $variantId ? (string) $productId . ':' . (string) $variantId : (string) $productId;

        if (Auth::check()) {
            $cart = Cart::firstOrCreate([
                'user_id' => Auth::id(),
                'vendor_id' => $vId
            ]);
            $cartItem = $cart->items()
                ->where('product_id', $productId)
                ->where('variant_id', $variantId)
                ->first();

            $currentQty = $cartItem ? $cartItem->quantity : 0;
            $newQuantity = $currentQty + $quantity;

            // Stock Check
            if ($variant) {
                if ($variant->stock < $newQuantity) {
                    return ['success' => false, 'error' => __('Only :count units available for this option.', ['count' => $variant->stock])];
                }
            } else {
                if (!$product->hasStock($newQuantity)) {
                    return ['success' => false, 'error' => __('Only :count units available in stock.', ['count' => $product->stock])];
                }
            }

            $cart->items()->updateOrCreate(
                ['product_id' => $productId, 'variant_id' => $variantId],
                ['quantity' => $newQuantity]
            );

            $cart->touch();
        } else {
            $sessionKey = $this->getSessionKey($vId);
            $cart = Session::get($sessionKey, []);

            $currentQty = isset($cart[$key]) ? $cart[$key]['quantity'] : 0;
            $newQuantity = $currentQty + $quantity;

            if ($variant) {
                if ($variant->stock < $newQuantity) {
                    return ['success' => false, 'error' => __('Only :count units available for this option.', ['count' => $variant->stock])];
                }
            } else {
                if (!$product->hasStock($newQuantity)) {
                    return ['success' => false, 'error' => __('Only :count units available in stock.', ['count' => $product->stock])];
                }
            }

            if (isset($cart[$key])) {
                $cart[$key]['quantity'] = $newQuantity;
            } else {
                $cart[$key] = [
                    "product_id" => $productId,
                    "variant_id" => $variantId,
                    "quantity" => $quantity,
                ];
            }
            Session::put($sessionKey, $cart);
        }

        return ['success' => true, 'message' => __('Product added to cart successfully!')];
    }

    public function updateQuantity($key, int $quantity, $vendorId = null)
    {
        $vId = $vendorId ?? $this->getCurrentVendorId();

        if ($quantity <= 0) {
            return $this->removeItem($key, $vId);
        }

        $parts = explode(':', $key);
        $productId = (int) $parts[0];
        $variantId = isset($parts[1]) ? (int) $parts[1] : null;

        $product = Product::find($productId);
        $variant = $variantId ? \App\Models\ProductVariant::find($variantId) : null;

        // Stock Check
        if ($variant) {
            if ($variant->stock < $quantity) {
                return ['success' => false, 'error' => __('Only :count units available for this option.', ['count' => $variant->stock])];
            }
        } elseif ($product) {
            if (!$product->hasStock($quantity)) {
                return ['success' => false, 'error' => __('Only :count units available in stock.', ['count' => $product->stock])];
            }
        }

        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->where('vendor_id', $vId)->first();
            if ($cart) {
                $cart->items()
                    ->where('product_id', $productId)
                    ->where('variant_id', $variantId)
                    ->update(['quantity' => $quantity]);
                $cart->touch();
                return ['success' => true, 'message' => __('Cart updated successfully')];
            }
        } else {
            $sessionKey = $this->getSessionKey($vId);
            $cart = Session::get($sessionKey, []);
            if (isset($cart[$key])) {
                $cart[$key]["quantity"] = $quantity;
                Session::put($sessionKey, $cart);
                return ['success' => true, 'message' => __('Cart updated successfully')];
            }
        }
        return ['success' => false];
    }

    public function removeItem($key, $vendorId = null)
    {
        $vId = $vendorId ?? $this->getCurrentVendorId();
        $parts = explode(':', $key);
        $productId = (int) $parts[0];
        $variantId = isset($parts[1]) ? (int) $parts[1] : null;

        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->where('vendor_id', $vId)->first();
            if ($cart) {
                $cart->items()
                    ->where('product_id', $productId)
                    ->where('variant_id', $variantId)
                    ->delete();
                $cart->touch();
                return ['success' => true, 'message' => __('Product removed successfully')];
            }
        } else {
            $sessionKey = $this->getSessionKey($vId);
            $cart = Session::get($sessionKey, []);
            if (isset($cart[$key])) {
                unset($cart[$key]);
                Session::put($sessionKey, $cart);
                return ['success' => true, 'message' => __('Product removed successfully')];
            }
        }
        return ['success' => false];
    }

    private function getRawCartItems($vendorId = null)
    {
        $vId = $vendorId ?? $this->getCurrentVendorId();

        if (Auth::check()) {
            // Check if we need to merge session cart first
            $sessionKey = $this->getSessionKey($vId);
            if (Session::has($sessionKey) && !empty(Session::get($sessionKey))) {
                $this->persistToDatabase($vId);
            }

            $cart = Cart::with('items')->firstOrCreate([
                'user_id' => Auth::id(),
                'vendor_id' => $vId
            ]);

            $raw = [];
            foreach ($cart->items as $item) {
                $key = $item->variant_id ? "{$item->product_id}:{$item->variant_id}" : "{$item->product_id}";
                $raw[$key] = [
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'quantity' => $item->quantity
                ];
            }
            return $raw;
        }

        $sessionCart = Session::get($this->getSessionKey($vId), []);
        return $sessionCart; // In session we already use the key
    }

    public function persistToDatabase($vendorId = null)
    {
        if (!Auth::check())
            return;

        if ($vendorId) {
            $this->persistSingleVendorCart($vendorId);
        } else {
            // Persist all vendor carts found in session
            $sessionData = Session::all();
            foreach ($sessionData as $key => $value) {
                if ($key === 'cart_main') {
                    $this->persistSingleVendorCart(null);
                } elseif (strpos($key, 'cart_vendor_') === 0) {
                    $vId = (int) str_replace('cart_vendor_', '', $key);
                    $this->persistSingleVendorCart($vId);
                }
            }
        }
    }

    private function persistSingleVendorCart($vId)
    {
        $sessionKey = $this->getSessionKey($vId);
        $sessionCart = Session::get($sessionKey, []);

        if (!empty($sessionCart)) {
            $cart = Cart::firstOrCreate([
                'user_id' => Auth::id(),
                'vendor_id' => $vId
            ]);

            foreach ($sessionCart as $key => $details) {
                $productId = $details['product_id'];
                $variantId = $details['variant_id'] ?? null;

                $item = $cart->items()
                    ->where('product_id', $productId)
                    ->where('variant_id', $variantId)
                    ->first();

                if ($item) {
                    $item->update(['quantity' => $details['quantity']]);
                } else {
                    $cart->items()->create([
                        'product_id' => $productId,
                        'variant_id' => $variantId,
                        'quantity' => $details['quantity']
                    ]);
                }
            }
            Session::forget($sessionKey);
        }
    }

    public function clearCart($vendorId = null)
    {
        $vId = $vendorId ?? $this->getCurrentVendorId();
        $sessionKey = $this->getSessionKey($vId);

        Session::forget($sessionKey);
        Session::forget('coupon'); // Coupons are currently global per session, might need vendor-specific coupons later

        if (Auth::check()) {
            Cart::where('user_id', Auth::id())->where('vendor_id', $vId)->delete();
        }
    }
}
