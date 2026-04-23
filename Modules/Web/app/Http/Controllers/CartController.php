<?php

namespace Modules\Web\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $coupon = null;
        $discount = 0;
        if (session()->has('coupon')) {
            $couponData = session()->get('coupon');
            $coupon = \App\Models\Coupon::where('code', $couponData['code'])->first();
            
            if ($coupon && $coupon->isValid()) {
                if ($total >= $coupon->min_order_amount) {
                    if ($coupon->type === 'percentage') {
                        $discount = ($total * $coupon->value) / 100;
                    } else {
                        $discount = $coupon->value;
                    }
                } else {
                    session()->forget('coupon');
                    return redirect()->route('web.cart', ['vendor_id' => request('vendor_id')]) ->with('error', __('Minimum order amount for this coupon is :amount', ['amount' => $coupon->min_order_amount]));
                }
            } else {
                session()->forget('coupon');
            }
        }
        
        $finalTotal = max(0, $total - $discount);
        
        return view('web::cart', compact('cart', 'total', 'coupon', 'discount', 'finalTotal'));
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $coupon = \App\Models\Coupon::where('code', $request->code)->first();

        if (!$coupon) {
            return redirect()->back()->with('error', __('Invalid coupon code.'));
        }

        if (!$coupon->isValid()) {
            return redirect()->back()->with('error', __('This coupon is no longer valid.'));
        }

        if (auth()->check() && !$coupon->canBeUsedByUser(auth()->user())) {
            return redirect()->back()->with('error', __('You have reached the usage limit for this coupon.'));
        }

        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        if ($total < $coupon->min_order_amount) {
            return redirect()->back()->with('error', __('Minimum order amount for this coupon is :amount', ['amount' => $coupon->min_order_amount]));
        }

        session()->put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value
        ]);

        return redirect()->back()->with('success', __('Coupon applied successfully!'));
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        return redirect()->back()->with('success', __('Coupon removed successfully.'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image,
                "currency" => $product->currency->symbol ?? '$'
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', __('Product added to cart successfully!'));
    }

    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            return response()->json(['success' => true, 'message' => __('Cart updated successfully')]);
        }
        return response()->json(['success' => false], 400);
    }

    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
                return response()->json(['success' => true, 'message' => __('Product removed successfully')]);
            }
        }
        return response()->json(['success' => false], 400);
    }
}
