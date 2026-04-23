<?php

namespace Modules\Web\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Web\Services\CartService;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $data = $this->cartService->getCartData();
        
        if (isset($data['error'])) {
            return redirect()->route('web.cart', ['vendor_id' => request('vendor_id')])->with('error', $data['error']);
        }

        return view('web::cart', $data);
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $result = $this->cartService->applyCoupon($request->code);

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['error']);
        }

        return redirect()->back()->with('success', $result['message']);
    }

    public function removeCoupon()
    {
        $result = $this->cartService->removeCoupon();
        return redirect()->back()->with('success', $result['message']);
    }

    public function add(Request $request, $id)
    {
        $result = $this->cartService->addToCart($id);
        return redirect()->back()->with('success', $result['message']);
    }

    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $result = $this->cartService->updateQuantity($request->id, $request->quantity);
            if ($result['success']) {
                return response()->json(['success' => true, 'message' => $result['message']]);
            }
        }
        return response()->json(['success' => false], 400);
    }

    public function remove(Request $request)
    {
        if ($request->id) {
            $result = $this->cartService->removeItem($request->id);
            if ($result['success']) {
                return response()->json(['success' => true, 'message' => $result['message']]);
            }
        }
        return response()->json(['success' => false], 400);
    }
}
