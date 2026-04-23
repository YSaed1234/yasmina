<?php

namespace Modules\Web\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Web\Services\CheckoutService;

class CheckoutController extends Controller
{
    protected $checkoutService;

    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    public function index(Request $request)
    {
        $vendor = $request->attributes->get('current_vendor');
        $data = $this->checkoutService->getCheckoutData($vendor);

        if (isset($data['error'])) {
            return redirect()->route('web.shop', ['vendor_id' => request('vendor_id')])->with('error', $data['error']);
        }

        return view('web::checkout', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id,user_id,' . auth()->id(),
            'payment_method' => 'required|string|in:cod,card',
            'notes' => 'nullable|string',
        ]);

        $vendor = $request->attributes->get('current_vendor');
        $result = $this->checkoutService->placeOrder($request->all(), $vendor);

        if (!$result['success']) {
            return back()->with('error', $result['error']);
        }

        $order = $result['order'];
        $vendorParam = $vendor->slug ?? $vendor->id ?? null;

        return redirect()->route('home', ['vendor_id' => $vendorParam])
            ->with('success', __('Order placed successfully! Your order ID is :id', ['id' => $order->id]));
    }
}
