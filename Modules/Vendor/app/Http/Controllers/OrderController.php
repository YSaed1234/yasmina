<?php

namespace Modules\Vendor\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Modules\Vendor\Services\OrderService;
use Modules\Vendor\Http\Requests\UpdateOrderStatusRequest;
use Modules\Vendor\Http\Requests\UpdateOrderPaymentStatusRequest;

class OrderController extends Controller
{
    protected $orderService;
    protected $manualOrderService;

    public function __construct(OrderService $orderService, ManualOrderService $manualOrderService)
    {
        $this->orderService = $orderService;
        $this->manualOrderService = $manualOrderService;
    }

    /**
     * Display a listing of the orders belonging to the vendor.
     */
    public function index()
    {
        $orders = $this->orderService->getVendorOrders(Auth::guard('vendor')->id());
        return view('vendor::orders.index', compact('orders'));
    }

    /**
     * Display the specified order details for the vendor.
     */
    public function show(Order $order)
    {
        $order = $this->orderService->getOrderDetailsForVendor($order, Auth::guard('vendor')->id());
        return view('vendor::orders.show', compact('order'));
    }

    /**
     * Update the order status.
     */
    public function updateStatus(UpdateOrderStatusRequest $request, Order $order)
    {
        $this->orderService->updateOrderStatus($order, Auth::guard('vendor')->id(), $request->validated());
        return back()->with('success', __('Order status updated successfully.'));
    }

    /**
     * Update the payment status of the order.
     */
    public function updatePaymentStatus(UpdateOrderPaymentStatusRequest $request, Order $order)
    {
        $this->orderService->updatePaymentStatus($order, Auth::guard('vendor')->id(), $request->payment_status);
        return back()->with('success', __('Payment status updated successfully.'));
    }

    public function recordPayment(\Illuminate\Http\Request $request, Order $order)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'receipt_image' => 'nullable|image|max:2048',
            'note' => 'nullable|string|max:1000',
            'payment_method' => 'nullable|string|max:255',
        ]);

        $this->orderService->recordPayment($order, Auth::guard('vendor')->id(), $request->all());

        return back()->with('success', __('Payment recorded successfully.'));
    }

    public function deletePayment(Order $order, $paymentId)
    {
        $this->orderService->deletePayment($order, Auth::guard('vendor')->id(), $paymentId);
        return back()->with('success', __('Payment deleted successfully.'));
    }

    public function create()
    {
        return view('vendor::orders.create');
    }

    public function store(StoreManualOrderRequest $request)
    {
        try {
            $order = $this->manualOrderService->create($request->validated());
            return redirect()->route('vendor.orders.show', $order->id)->with('success', __('Manual order created successfully.'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function searchProducts(\Illuminate\Http\Request $request)
    {
        $search = $request->get('q');
        $vendorId = Auth::guard('vendor')->id();
        
        $products = \App\Models\Product::with(['variants' => function($q) {
                $q->where('stock', '>', 0);
            }, 'currency'])
            ->where('vendor_id', $vendorId)
            ->where('is_enabled', true)
            ->whereNull('vendor_deactivated_at')
            ->where(function($q) use ($search) {
                $q->whereTranslationLike('name', "%$search%")
                  ->orWhereHas('variants', function($sq) use ($search) {
                      $sq->where('sku', 'like', "%$search%");
                  });
            })
            ->where(function($q) {
                $q->whereHas('variants', function($sq) {
                    $sq->where('stock', '>', 0);
                })
                ->orWhere(function($sq) {
                    $sq->doesntHave('variants')->where('stock', '>', 0);
                });
            })
            ->limit(20)
            ->get();

        $results = [];
        foreach ($products as $product) {
            if ($product->variants->isEmpty()) {
                $results[] = $this->formatProductItem($product);
            } else {
                foreach ($product->variants as $variant) {
                    $results[] = $this->formatVariantItem($product, $variant);
                }
            }
        }

        return response()->json(['results' => $results]);
    }

    private function formatProductItem($product) {
        $effectivePrice = $product->effective_price;
        $originalPrice = $product->price;
        $priceText = $effectivePrice . ' ' . ($product->currency->symbol ?? __('LE'));
        if ($effectivePrice < $originalPrice) {
            $priceText .= ' <span class="line-through text-gray-400 ml-2">' . $originalPrice . '</span>';
        }

        return [
            'id' => $product->id . '_0',
            'product_id' => $product->id,
            'variant_id' => null,
            'text' => $product->name,
            'price' => $effectivePrice,
            'price_html' => $priceText,
            'image' => $product->image ? asset('storage/' . $product->image) : asset('assets/placeholder.png'),
            'currency' => $product->currency->symbol ?? __('LE')
        ];
    }

    private function formatVariantItem($product, $variant) {
        $price = $variant->price ?: $product->effective_price;
        $priceText = $price . ' ' . ($product->currency->symbol ?? __('LE'));
        
        $text = $product->name;
        $attrs = [];
        if ($variant->color) $attrs[] = $variant->color;
        if ($variant->size) $attrs[] = $variant->size;
        
        if (!empty($attrs)) {
            $text .= ' [' . implode(' / ', $attrs) . ']';
        }
        
        return [
            'id' => $product->id . '_' . $variant->id,
            'product_id' => $product->id,
            'variant_id' => $variant->id,
            'text' => $text,
            'price' => $price,
            'price_html' => $priceText,
            'image' => $variant->image ? asset('storage/' . $variant->image) : ($product->image ? asset('storage/' . $product->image) : asset('assets/placeholder.png')),
            'currency' => $product->currency->symbol ?? __('LE')
        ];
    }
}
