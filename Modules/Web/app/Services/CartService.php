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
        
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        foreach ($cart as $id => &$item) {
            if (isset($products[$id])) {
                $product = $products[$id];
                $item['price'] = $product->discount_price ?? $product->price;
                $item['original_price'] = $product->price;
                $total += $item['price'] * $item['quantity'];
                $totalOriginal += $item['original_price'] * $item['quantity'];
            }
        }
        Session::put('cart', $cart);

        $productSavings = $totalOriginal - $total;

        $coupon = null;
        $discount = 0;
        
        if (Session::has('coupon')) {
            $couponData = Session::get('coupon');
            $coupon = Coupon::where('code', $couponData['code'])->first();
            
            if ($coupon && $coupon->isValid()) {
                if ($total >= $coupon->min_order_amount) {
                    if ($coupon->type === 'percentage') {
                        $discount = ($total * $coupon->value) / 100;
                    } else {
                        $discount = $coupon->value;
                    }
                } else {
                    Session::forget('coupon');
                    return [
                        'cart' => $cart,
                        'total' => $total,
                        'coupon' => null,
                        'discount' => 0,
                        'finalTotal' => $total,
                        'error' => __('Minimum order amount for this coupon is :amount', ['amount' => $coupon->min_order_amount])
                    ];
                }
            } else {
                Session::forget('coupon');
            }
        }
        
        $finalTotal = max(0, $total - $discount);
        
        return [
            'cart' => $cart,
            'total' => $total,
            'totalOriginal' => $totalOriginal,
            'productSavings' => $productSavings,
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
            $cart[$productId] = [
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->discount_price ?? $product->price,
                "original_price" => $product->price,
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
