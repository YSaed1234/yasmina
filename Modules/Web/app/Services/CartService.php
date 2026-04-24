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
    public function getCartCount()
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            return $cart ? $cart->items()->count() : 0;
        }

        return count(Session::get('cart', []));
    }

    public function getCartData()
    {
        $rawItems = $this->getRawCartItems();
        $cart = [];
        
        foreach ($rawItems as $productId => $quantity) {
            $cart[$productId] = ['quantity' => $quantity];
        }

        $total = 0;
        $totalOriginal = 0;
        $totalItemsCount = 0;
        
        $productIds = array_keys($cart);
        $products = Product::with('vendor', 'currency')->whereIn('id', $productIds)->get()->keyBy('id');

        $vendorGroups = [];

        foreach ($cart as $id => &$item) {
            if (isset($products[$id])) {
                $product = $products[$id];
                $item['name'] = $product->name;
                $item['price'] = $product->is_gift ? 0 : $product->effective_price;
                $item['original_price'] = $product->price;
                $item['is_flash_sale'] = $product->hasActiveFlashSale();
                $item['vendor_id'] = $product->vendor_id;
                $item['image'] = $product->image;
                $item['currency'] = $product->currency->symbol ?? '$';
                $item['is_gift'] = $product->is_gift;
                
                $itemTotal = $item['price'] * $item['quantity'];
                $itemTotalOriginal = $item['original_price'] * $item['quantity'];
                
                // Stock Validation
                $item['in_stock'] = $product->hasStock($item['quantity']);
                $item['available_stock'] = $product->stock;

                $total += $itemTotal;
                $totalOriginal += $itemTotalOriginal;
                $totalItemsCount += $item['quantity'];

                // Group by vendor
                if (!isset($vendorGroups[$product->vendor_id])) {
                    $vendorGroups[$product->vendor_id] = [
                        'vendor' => $product->vendor,
                        'total' => 0,
                        'items_count' => 0
                    ];
                }
                $vendorGroups[$product->vendor_id]['total'] += $itemTotal;
                $vendorGroups[$product->vendor_id]['items_count'] += $item['quantity'];
            } else {
                // If product no longer exists, remove from cart
                $this->removeItem($id);
                unset($cart[$id]);
            }
        }
        
        if (!Auth::check()) {
            Session::put('cart', $cart);
        }

        // Calculate BOGO & Cross-sell Promotions
        $promotionalDiscount = 0;
        $appliedPromotions = [];
        $activePromotions = \App\Models\Promotion::where('is_active', true)
            ->whereIn('buy_product_id', $productIds)
            ->where(function($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            })
            ->get();

        foreach ($activePromotions as $promo) {
            if (isset($cart[$promo->buy_product_id])) {
                $buyQtyInCart = $cart[$promo->buy_product_id]['quantity'];
                
                if ($promo->type === 'bogo_same') {
                    // Logic for "Buy 2 Get 1 Free" (Total 3 items, 1 free)
                    $cycle = $promo->buy_quantity + $promo->get_quantity;
                    $eligibleQty = floor($buyQtyInCart / $cycle) * $promo->get_quantity;
                } else {
                    // Logic for "Buy A Get B at discount"
                    $timesApplicable = floor($buyQtyInCart / $promo->buy_quantity);
                    if (isset($cart[$promo->get_product_id])) {
                        $getQtyInCart = $cart[$promo->get_product_id]['quantity'];
                        $eligibleQty = min($timesApplicable * $promo->get_quantity, $getQtyInCart);
                    } else {
                        $eligibleQty = 0;
                    }
                }

                if ($eligibleQty > 0) {
                    $targetProduct = $products[$promo->get_product_id] ?? null;
                    if ($targetProduct) {
                        // Validate if "Get" items are available in stock
                        // For bogo_same, it's already checked in the items loop
                        // For different product, check if the getQtyInCart is within stock
                        $isFulfillable = true;
                        if ($promo->type !== 'bogo_same') {
                            $isFulfillable = $targetProduct->hasStock($cart[$promo->get_product_id]['quantity']);
                        }

                        if ($isFulfillable) {
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
                        } else {
                            $appliedPromotions[] = [
                                'name' => $promo->name,
                                'amount' => 0,
                                'error' => __('Insufficient stock for the free/discounted items in this deal.'),
                                'details' => __('Deal cannot be applied due to stock limits.')
                            ];
                        }
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
        
        $totalAfterVendorDiscounts = max(0, $totalAfterPromotions - $vendorDiscount);
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
            'promotionalDiscount' => $promotionalDiscount,
            'appliedPromotions' => $appliedPromotions,
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

        if (Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            $cartItem = $cart->items()->where('product_id', $productId)->first();
            
            $currentQty = $cartItem ? $cartItem->quantity : 0;
            $newQuantity = $currentQty + $quantity;

            if (!$product->hasStock($newQuantity)) {
                return ['success' => false, 'error' => __('Only :count units available in stock.', ['count' => $product->stock])];
            }

            $cart->items()->updateOrCreate(
                ['product_id' => $productId],
                ['quantity' => $newQuantity]
            );
            
            $cart->touch(); // Update cart updated_at
        } else {
            $cart = Session::get('cart', []);
            if (isset($cart[$productId])) {
                $newQuantity = $cart[$productId]['quantity'] + $quantity;
                if (!$product->hasStock($newQuantity)) {
                    return ['success' => false, 'error' => __('Only :count units available in stock.', ['count' => $product->stock])];
                }
                $cart[$productId]['quantity'] = $newQuantity;
            } else {
                if (!$product->hasStock($quantity)) {
                    return ['success' => false, 'error' => __('Only :count units available in stock.', ['count' => $product->stock])];
                }
                $cart[$productId] = [
                    "quantity" => $quantity,
                ];
            }
            Session::put('cart', $cart);
        }

        return ['success' => true, 'message' => __('Product added to cart successfully!')];
    }

    public function updateQuantity(int $productId, int $quantity)
    {
        if ($quantity <= 0) {
            return $this->removeItem($productId);
        }

        $product = Product::find($productId);
        if ($product && !$product->hasStock($quantity)) {
            return ['success' => false, 'error' => __('Only :count units available in stock.', ['count' => $product->stock])];
        }

        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            if ($cart) {
                $cart->items()->where('product_id', $productId)->update(['quantity' => $quantity]);
                $cart->touch();
                return ['success' => true, 'message' => __('Cart updated successfully')];
            }
        } else {
            $cart = Session::get('cart', []);
            if (isset($cart[$productId])) {
                $cart[$productId]["quantity"] = $quantity;
                Session::put('cart', $cart);
                return ['success' => true, 'message' => __('Cart updated successfully')];
            }
        }
        return ['success' => false];
    }

    public function removeItem(int $productId)
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            if ($cart) {
                $cart->items()->where('product_id', $productId)->delete();
                $cart->touch();
                return ['success' => true, 'message' => __('Product removed successfully')];
            }
        } else {
            $cart = Session::get('cart', []);
            if (isset($cart[$productId])) {
                unset($cart[$productId]);
                Session::put('cart', $cart);
                return ['success' => true, 'message' => __('Product removed successfully')];
            }
        }
        return ['success' => false];
    }

    private function getRawCartItems()
    {
        if (Auth::check()) {
            // Check if we need to merge session cart first
            if (Session::has('cart') && !empty(Session::get('cart'))) {
                $this->persistToDatabase();
            }

            $cart = Cart::with('items')->firstOrCreate(['user_id' => Auth::id()]);
            return $cart->items->pluck('quantity', 'product_id')->toArray();
        }

        $sessionCart = Session::get('cart', []);
        $raw = [];
        foreach ($sessionCart as $id => $details) {
            $raw[$id] = $details['quantity'];
        }
        return $raw;
    }

    public function persistToDatabase()
    {
        if (Auth::check()) {
            $sessionCart = Session::get('cart', []);
            if (!empty($sessionCart)) {
                $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
                
                foreach ($sessionCart as $productId => $details) {
                    $item = $cart->items()->where('product_id', $productId)->first();
                    if ($item) {
                        // If exists in DB, maybe add quantities or keep session qty? 
                        // Usually, session qty is the most recent intent.
                        $item->update(['quantity' => $details['quantity']]);
                    } else {
                        $cart->items()->create([
                            'product_id' => $productId,
                            'quantity' => $details['quantity']
                        ]);
                    }
                }
                Session::forget('cart');
            }
        }
    }
}
