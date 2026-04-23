<?php

namespace Modules\Web\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('web.shop')->with('error', __('Your cart is empty!'));
        }

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
                }
            } else {
                session()->forget('coupon');
            }
        }

        $finalTotal = max(0, $total - $discount);
        $vendor_id = ($request->vendor_id ?? null);
        $addresses = \App\Models\Address::with(['governorate', 'region'])->where('user_id', auth()->id())->where('vendor_id', $vendor_id)->get();

        return view('web::checkout', compact('cart', 'total', 'coupon', 'discount', 'finalTotal', 'addresses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id,user_id,' . auth()->id(),
            'payment_method' => 'required|string|in:cod,card',
            'notes' => 'nullable|string',
        ]);

        $vendor_id = $request->get('vendor_id');
        $address = \App\Models\Address::with(['governorate', 'region'])->findOrFail($request->address_id);

        $region = null;
        if ($vendor_id) {
            $region = \App\Models\Region::where('vendor_id', $vendor_id)
                ->where('governorate_id', $address->governorate_id)
                ->where('name', $address->region->name)
                ->where('is_active', true)
                ->first();
        }

        if (!$region) {
            $region = $address->region;
        }

        if (!$region || !$region->is_active) {
            return back()->with('error', __('Shipping is not available for the selected address / area.'));
        }

        $shippingCost = $region->rate;

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('web.shop')->with('error', __('Your cart is empty!'));
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $discount = 0;
        $coupon = null;
        if (session()->has('coupon')) {
            $couponData = session()->get('coupon');
            $coupon = \App\Models\Coupon::where('code', $couponData['code'])->first();
            if ($coupon && $coupon->isValid() && $total >= $coupon->min_order_amount) {
                if ($coupon->type === 'percentage') {
                    $discount = ($total * $coupon->value) / 100;
                } else {
                    $discount = $coupon->value;
                }
            }
        }

        $finalTotal = max(0, $total - $discount) + $shippingCost;

        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id' => auth()->id(),
                'vendor_id' => $vendor_id,
                'total' => $finalTotal,
                'shipping_amount' => $shippingCost,
                'status' => 'new',
                'payment_status' => 'pending',
                'payment_method' => $request->payment_method,
                'shipping_details' => [
                    'name' => $address->name,
                    'email' => auth()->user()->email,
                    'phone' => $address->phone,
                    'address' => $address->address_line1 . ($address->address_line2 ? ', ' . $address->address_line2 : ''),
                    'city' => $address->city,
                    'country' => $address->country,
                    'shipping_zone' => $address->shippingZone ? $address->shippingZone->name : null
                ],
                'notes' => $request->notes,
                'coupon_id' => $coupon ? $coupon->id : null,
                'discount_amount' => $discount,
            ]);

            foreach ($cart as $id => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                ]);
            }

            if ($coupon) {
                $coupon->increment('used_count');
                if (auth()->check()) {
                    $userUsage = $coupon->users()->where('user_id', auth()->id())->first();
                    if ($userUsage) {
                        $coupon->users()->updateExistingPivot(auth()->id(), [
                            'usage_count' => $userUsage->pivot->usage_count + 1
                        ]);
                    } else {
                        $coupon->users()->attach(auth()->id(), ['usage_count' => 1]);
                    }
                }
            }

            DB::commit();

            // Send Notification to user
            auth()->user()->notify(new \App\Notifications\NewOrderNotification($order));

            session()->forget(['cart', 'coupon']);

            return redirect()->route('home')->with('success', __('Order placed successfully! Your order ID is :id', ['id' => $order->id]));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', __('Something went wrong! Please try again.'));
        }
    }
}
