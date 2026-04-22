<?php

namespace Modules\Web\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('web.shop')->with('error', __('Your cart is empty!'));
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('web::checkout', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string',
            'payment_method' => 'required|string|in:cod,card',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('web.shop')->with('error', __('Your cart is empty!'));
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id' => auth()->id(),
                'total' => $total,
                'status' => 'new',
                'payment_status' => 'pending',
                'payment_method' => $request->payment_method,
                'shipping_details' => [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'city' => $request->city,
                ],
                'notes' => $request->notes,
            ]);

            foreach ($cart as $id => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                ]);
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('home')->with('success', __('Order placed successfully! Your order ID is :id', ['id' => $order->id]));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', __('Something went wrong! Please try again.'));
        }
    }
}
