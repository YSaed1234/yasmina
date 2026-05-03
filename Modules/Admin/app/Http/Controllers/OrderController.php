<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Modules\Admin\Services\OrderService;
use Modules\Admin\Services\ManualOrderService;
use Modules\Admin\Services\CategoryService;
use Modules\Admin\Http\Requests\UpdateOrderStatusRequest;
use Modules\Admin\Http\Requests\StoreManualOrderRequest;

class OrderController extends Controller
{
    protected $orderService;
    protected $manualOrderService;
    protected $categoryService;

    public function __construct(OrderService $orderService, ManualOrderService $manualOrderService, CategoryService $categoryService)
    {
        $this->orderService = $orderService;
        $this->manualOrderService = $manualOrderService;
        $this->categoryService = $categoryService;
    }

    public function index(\Illuminate\Http\Request $request)
    {
        $orders = $this->orderService->getAllPaginated(10, $request->all());
        return view('admin::orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order = $this->orderService->getOrderDetails($order);
        
        $drivers = \App\Models\Driver::with('vendor')->where('is_active', true)
            ->when($order->vendor_id, function($query) use ($order) {
                return $query->where(function($q) use ($order) {
                    $q->where('vendor_id', $order->vendor_id)
                      ->orWhereNull('vendor_id');
                });
            })
            ->get();

        return view('admin::orders.show', compact('order', 'drivers'));
    }

    public function updateStatus(UpdateOrderStatusRequest $request, Order $order)
    {
        $this->orderService->updateStatus($order, $request->validated());
        return back()->with('success', __('Order status updated successfully.'));
    }

    public function updatePaymentStatus(\Illuminate\Http\Request $request, Order $order)
    {
        $request->validate(['payment_status' => 'required|string|in:pending,paid,partially_paid,failed']);
        $this->orderService->updatePaymentStatus($order, $request->payment_status);
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

        $this->orderService->recordPayment($order, $request->all());

        return back()->with('success', __('Payment recorded successfully.'));
    }

    public function deletePayment(Order $order, $paymentId)
    {
        $this->orderService->deletePayment($order, $paymentId);
        return back()->with('success', __('Payment deleted successfully.'));
    }

    public function destroy(Order $order)
    {
        $this->orderService->delete($order);
        return redirect()->route('admin.orders.index')->with('success', __('Order deleted successfully.'));
    }

    public function assignDriver(\Illuminate\Http\Request $request, Order $order)
    {
        $request->validate([
            'driver_id' => 'required|exists:drivers,id'
        ]);

        $order->update(['driver_id' => $request->driver_id]);

        if ($order->user) {
            $order->user->notify(new \App\Notifications\DriverAssignedNotification($order));
        }

        return back()->with('success', __('Driver assigned successfully.'));
    }

    public function create()
    {
        $vendors = \App\Models\Vendor::where('status', 'active')->get();
        return view('admin::orders.create', compact('vendors'));
    }

    public function store(\Modules\Admin\Http\Requests\StoreManualOrderRequest $request)
    {
        try {
            $order = $this->manualOrderService->create($request->validated());
            return redirect()->route('admin.orders.show', $order->id)->with('success', __('Manual order created successfully.'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function searchProducts(\Illuminate\Http\Request $request)
    {
        $search = $request->get('q');
        $vendorId = $request->get('vendor_id');
        
        $products = \App\Models\Product::with(['variants' => function($q) {
                $q->where('stock', '>', 0);
            }, 'currency'])
            ->where('is_enabled', true)
            ->whereNull('vendor_deactivated_at')
            ->when($vendorId, function($q) use ($vendorId) {
                return $q->where('vendor_id', $vendorId);
            })
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
