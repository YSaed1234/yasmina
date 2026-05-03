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

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
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
}
